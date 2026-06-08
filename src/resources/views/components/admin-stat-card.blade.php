@props([
    'cardClass' => 'stat-card',
    'valueClass' => 'value',
    'label',
    'value',
    'changeText' => null,
    'iconClass' => 'icon-blue'
])

<div class="{{ $cardClass }}">
  <div class="info">
    <div class="label">{{ $label }}</div>
    <div class="{{ $valueClass }}">{{ $value }}</div>
    @if($changeText)
    <div class="change up">
      <svg width="20" height="12" viewBox="0 0 20 12" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M14 0L16.29 2.29L11.41 7.17L7.41 3.17L0 10.59L1.41 12L7.41 6L11.41 10L17.71 3.71L20 6V0H14Z" fill="#00B69B"/>
      </svg>
      {{ $changeText }}
    </div>
    @endif
  </div>
  <div class="stat-right">
    <div class="icon-box {{ $iconClass }}">
      {{ $slot }}
    </div>
  </div>
</div>
