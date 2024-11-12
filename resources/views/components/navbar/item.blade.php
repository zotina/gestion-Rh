<li class="@if($href == $active) active @endif">
    <a
        class="fx__navbar-item"
        href="{{ $href }}"
    >
        {{ $slot }}
    </a>
</li>
