{{-- Banner de sesion activa con los datos de la entidad (mock hasta integrar autenticacion). --}}
<div class="mb-5 rounded-[18px] border-[1.5px] {{ $bordeClase }} bg-white p-[18px] shadow-sm">
    <div class="mb-3.5 flex items-center justify-between">
        <span class="flex items-center gap-1.5 rounded-full bg-green-100 px-2.5 py-1">
            <span class="h-[7px] w-[7px] rounded-full bg-unefa-green"></span>
            <span class="text-[10px] font-black tracking-[0.5px] text-unefa-green">SESIÓN ACTIVA</span>
        </span>
        <span class="rounded-lg px-2.5 py-1 text-[11px] font-extrabold tracking-[0.3px] {{ $insigniaFondo }} {{ $insigniaTexto }}">
            {{ $insignia }}
        </span>
    </div>

    <div class="mb-3.5 flex items-center gap-3.5">
        <span class="flex h-[54px] w-[54px] shrink-0 items-center justify-center rounded-2xl {{ $acentoFondo }}">
            @include('partials.icon', ['name' => $icono, 'clase' => 'h-7 w-7 text-white'])
        </span>
        <div>
            <p class="mb-0.5 text-base font-black text-slate-900">{{ $nombre }}</p>
            <p class="mb-0.5 text-[13px] font-bold text-unefa-blue">{{ $cedula }}</p>
            <p class="text-xs font-semibold text-slate-500">{{ $departamento }}</p>
            <p class="mt-0.5 text-[11px] text-slate-500">{{ $subtitulo }}</p>
        </div>
    </div>

    <div class="flex items-center justify-between border-t border-slate-200 pt-3">
        <p class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-500">
            ID Institucional:
            <span class="font-mono text-[11px] font-extrabold text-slate-900">{{ $matricula }}</span>
        </p>
        <a href="{{ route('login') }}" class="flex items-center gap-1 rounded-md px-2 py-1 text-xs font-bold text-red-500 transition hover:bg-red-50">
            @include('partials.icon', ['name' => 'log-out', 'clase' => 'h-3.5 w-3.5 text-red-500'])
            Cerrar sesión
        </a>
    </div>
</div>
