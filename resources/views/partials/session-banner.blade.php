{{-- Banner de sesion activa con los datos de la entidad (mock hasta integrar autenticacion). --}}
{{-- Superficie blanca con filete dorado y barra de acento configurable por rol. --}}
@php $distribuir = !empty($distribuir); @endphp
<div class="{{ $claseContenedor ?? 'mb-5' }} overflow-hidden rounded-[18px] border border-slate-200 bg-white shadow-sm">
    {{-- Filete dorado institucional --}}
    <div class="h-[3px] w-full bg-unefa-gold" aria-hidden="true"></div>

    <div class="relative p-[18px] {{ $distribuir ? 'flex h-full flex-col' : '' }}">
        {{-- Barra de acento del rol (el color lo define cada dashboard) --}}
        <div class="absolute inset-y-0 left-0 w-1 {{ $acentoFondo }}" aria-hidden="true"></div>

        <div class="mb-3.5 flex flex-wrap items-center justify-between gap-2 pl-3 {{ $distribuir ? 'shrink-0' : '' }}">
            <span class="flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-1">
                <span class="h-[7px] w-[7px] rounded-full bg-emerald-600" aria-hidden="true"></span>
                <span class="text-[10px] font-black tracking-[0.5px] text-emerald-700">SESIÓN ACTIVA</span>
            </span>
            <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-[11px] font-extrabold tracking-[0.3px] text-slate-700 ring-1 ring-slate-200">
                {{ $insignia }}
            </span>
        </div>

        <div class="mb-3.5 flex items-center gap-3.5 pl-3 {{ $distribuir ? 'flex-1 py-3' : '' }}">
            <span class="flex h-[54px] w-[54px] shrink-0 items-center justify-center rounded-2xl bg-slate-100 ring-1 ring-slate-200">
                @include('partials.icon', ['name' => $icono, 'clase' => 'h-7 w-7 text-slate-600'])
            </span>
            <div class="min-w-0">
                <p class="mb-0.5 text-base font-black text-slate-900">{{ $nombre }}</p>
                <p class="mb-0.5 text-[13px] font-extrabold text-amber-700">{{ $cedula }}</p>
                <p class="text-xs font-semibold text-slate-500">{{ $departamento }}</p>
                <p class="mt-0.5 text-[11px] text-slate-500">{{ $subtitulo }}</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-200 pt-3 pl-3 {{ $distribuir ? 'mt-auto shrink-0' : '' }}">
            <p class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-500">
                ID Institucional:
                <span class="font-mono text-[11px] font-extrabold text-slate-900">{{ $matricula }}</span>
            </p>
            <a href="{{ route('login') }}" class="flex items-center gap-1 rounded-md px-2 py-1 text-xs font-bold text-red-600 transition hover:bg-red-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900">
                @include('partials.icon', ['name' => 'log-out', 'clase' => 'h-3.5 w-3.5 text-red-600'])
                Cerrar sesión
            </a>
        </div>
    </div>
</div>
