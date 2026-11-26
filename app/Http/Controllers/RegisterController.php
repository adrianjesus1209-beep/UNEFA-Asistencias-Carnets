<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $cedula = preg_replace('/\D+/', '', (string) $request->input('cedula', $request->input('reg_cedula', '')));
        $nacionalidad = $request->input('nacionalidad', $request->input('reg_docType', 'V'));
        $telefono = $request->input('telefono', $request->input('reg_telefono', ''));
        $nombres = trim($request->input('nombres', $request->input('reg_nombres', '')));
        $apellidos = trim($request->input('apellidos', $request->input('reg_apellidos', '')));
        $email = strtolower(trim($request->input('email', $request->input('reg_email', ''))));
        $password = $request->input('password', $request->input('reg_password', ''));
        $confirmPassword = $request->input('password_confirmation', $request->input('reg_confirmPassword', ''));
        $carrera = trim($request->input('carrera', $request->input('reg_carrera', '')));
        $municipio = trim($request->input('municipio', $request->input('reg_municipio', '')));
        $direccion = trim($request->input('direccion', $request->input('reg_direccion', '')));
        $estado = trim($request->input('estado', $request->input('reg_estado', '')));
        $sede = trim($request->input('sede', $request->input('reg_sede', '')));
        $nivel = trim($request->input('nivel', $request->input('reg_nivel', '')));
        $turno = trim($request->input('turno', $request->input('reg_turno', '')));
        $condicion = trim($request->input('condicion', $request->input('reg_condicion', '')));
        $promedio = trim($request->input('promedio', $request->input('reg_promedio', '')));

        $validator = Validator::make([
            'cedula' => $cedula,
            'nacionalidad' => strtoupper($nacionalidad),
            'telefono' => $telefono,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'email' => $email,
            'password' => $password,
            'confirm_password' => $confirmPassword,
            'carrera' => $carrera,
            'municipio' => $municipio,
            'direccion' => $direccion,
            'estado' => $estado,
            'sede' => $sede,
            'nivel' => $nivel,
            'turno' => $turno,
            'condicion' => $condicion,
            'promedio' => $promedio,
        ], [
            'cedula' => 'required|min:7|max:9|unique:profile,id_number',
            'nacionalidad' => 'required|in:V,E',
            'telefono' => 'required|max:20|regex:/^[0-9+\- ()]+$/',
            'nombres' => 'required|max:100',
            'apellidos' => 'required|max:100',
            'email' => 'required|email|max:100|unique:user_account,email',
            'password' => 'required|min:8|max:255|same:confirm_password',
            'confirm_password' => 'required',
            'carrera' => 'required|max:100',
            'municipio' => 'required|max:100',
            'direccion' => 'required|max:255',
            'estado' => 'required|max:100',
            'sede' => 'required|max:100',
            'nivel' => 'required|max:50',
            'turno' => 'required|max:50',
            'condicion' => 'required|max:100',
            'promedio' => 'required|numeric|min:1|max:20',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Los datos del registro no son válidos.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()
                ->withErrors($validator)
                ->withInput($request->except(['password', 'password_confirmation', 'reg_password', 'reg_confirmPassword']));
        }

        $partesNombres = explode(' ', $nombres, 2);
        $firstName = mb_substr($partesNombres[0], 0, 50);
        $middleName = isset($partesNombres[1]) ? mb_substr($partesNombres[1], 0, 50) : null;

        $partesApellidos = explode(' ', $apellidos, 2);
        $lastName = mb_substr($partesApellidos[0], 0, 50);
        $secondLastName = isset($partesApellidos[1]) ? mb_substr($partesApellidos[1], 0, 50) : null;

        $careerId = DB::table('career')
            ->where('career_code', $carrera)
            ->orWhere('career_name', $carrera)
            ->value('id');

        if (!$careerId) {
            $careerId = DB::table('career')->value('id');
        }

        if (!$careerId) {
            return back()
                ->withInput($request->except(['password', 'password_confirmation', 'reg_password', 'reg_confirmPassword']))
                ->withErrors(['carrera' => 'No hay carreras registradas en el sistema.']);
        }

        $address = $direccion . ', ' . $municipio . ', ' . $estado . ', ' . $sede
            . ' | Nivel: ' . $nivel
            . ' | Carrera: ' . $carrera
            . ' | Turno: ' . $turno
            . ' | Modalidad: ' . $condicion
            . ' | Promedio: ' . $promedio;
        $address = mb_substr($address, 0, 255);

        try {
            DB::transaction(function () use (
                $cedula,
                $nacionalidad,
                $telefono,
                $firstName,
                $middleName,
                $lastName,
                $secondLastName,
                $email,
                $password,
                $careerId,
                $address
            ) {
                $profileId = DB::table('profile')->insertGetId([
                    'career_id' => $careerId,
                    'id_number' => $cedula,
                    'id_type' => strtoupper($nacionalidad),
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'second_last_name' => $secondLastName,
                    'current_semester' => 1,
                    'has_dragged_subjects' => false,
                    'address' => $address,
                    'phone' => mb_substr($telefono, 0, 20),
                    'profile_picture' => null,
                ]);

                $userId = DB::table('user_account')->insertGetId([
                    'profile_id' => $profileId,
                    'username' => $cedula,
                    'email' => $email,
                    'password_hash' => Hash::make($password),
                    'qr_token' => 'UNEFA-QR-' . strtoupper($nacionalidad) . $cedula,
                    'status' => 'Pending',
                ]);

                $studentRoleId = DB::table('system_role')
                    ->where('role_name', 'Student')
                    ->value('id');

                if (!$studentRoleId) {
                    throw new \Exception('El rol Student no existe.');
                }

                DB::table('user_role')->insert([
                    'user_id' => $userId,
                    'role_id' => $studentRoleId,
                    'is_active' => true,
                ]);
            });
        } catch (\Throwable $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'No se pudo guardar el registro.',
                ], 500);
            }

            return back()
                ->withInput($request->except(['password', 'password_confirmation', 'reg_password', 'reg_confirmPassword']))
                ->withErrors(['registro' => 'No se pudo guardar el registro.']);
        }

        return redirect()->route('registro')
            ->with('registro_guardado', 'Registro guardado correctamente.');
    }
}
