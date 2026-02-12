<script>
  document.addEventListener('DOMContentLoaded', function () {

    // bind dropdown
    function initDropdown(drop) {
      const selected = drop.querySelector('.selected');
      const options = drop.querySelectorAll('.dropdown-list li');
      const hiddenInput = drop.querySelector('input[type="hidden"]');

      selected.addEventListener('click', e => {
        e.stopPropagation();
        drop.classList.toggle('active');
      });

      options.forEach(opt => {
        opt.addEventListener('click', () => {
          selected.textContent = opt.textContent;
          hiddenInput.value = opt.dataset.value;
          drop.classList.remove('active');

          if (hiddenInput.id === 'guestCount') {
            const event = new Event('change');
            hiddenInput.dispatchEvent(event);
          }
        });
      });
    }

    document.querySelectorAll('.custom-dropdown:not(.guest-dropdown)').forEach(initDropdown);

    const guestCount = document.getElementById('guestCount');
    const guestList = document.getElementById('guestList');
    let guestsData = [];

    function guestTemplate(index, guestData = {}) {
      return `
        <div class="card shadow-sm p-3 mb-3 guest-item">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="text-brown fw-bold mb-0">{{ __('messages.tenkhachhang') }} ${index + 1}</h5>
            <button type="button" class="btn btn-link text-danger p-0 remove-guest">
              <i class="bi bi-trash-fill fs-5"></i>
            </button>
          </div>

          <div class="mb-3">
            <label class="form-label">{{ __('messages.tenkhachhang') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control guest-name" name="guests[${index}][name]" placeholder="{{ __('messages.vuilongnhap') }}" value="${guestData.name || ''}" >
            <div class="mt-2 text-danger error-name"></div>
          </div>

          <div class="mb-3">
            <label class="form-label">{{ __('messages.dichvu') }} <span class="text-danger">*</span></label>
            <div class="custom-dropdown guest-dropdown" data-name="guests[${index}][service_option_id]">
              <div class="selected">{{ __('messages.chondichvu') }}</div>
              <ul class="dropdown-list">
                @foreach($categories as $category)
                  @php $categoryServices = $services->filter(fn($s) => $s->category_id == $category->id); @endphp
                  @if($categoryServices->isNotEmpty())
                    <li class="fw-bold text-uppercase px-3 py-2" style="opacity:0.8;">{{ $category->translated_name }}</li>
                    @foreach($categoryServices as $service)
                      @foreach($service->options as $option)
                      
                        <li data-value="{{ $option->id }}">{{ $service->translated_name }} ({{ $option->duration }}')</li>
                      @endforeach
                    @endforeach
                  @endif
                @endforeach
              </ul>
              <input type="hidden" name="guests[${index}][service_option_id]" value="">
              <div class=" mt-2 text-danger error-service"></div>
            </div>
          </div>
        </div>
      `;
    }

    function renderGuests(count) {
      guestList.innerHTML = '';
      for (let i = 0; i < count; i++) {
        guestList.insertAdjacentHTML('beforeend', guestTemplate(i, guestsData[i] || {}));
      }

      // Bind dropdown trong guest mới
      guestList.querySelectorAll('.guest-dropdown').forEach(initDropdown);
    }

    function saveGuestsData() {
      const currentGuests = guestList.querySelectorAll('.guest-item');
      currentGuests.forEach((guestItem, index) => {
        const guestName = guestItem.querySelector(`input.guest-name`).value;
        const serviceOptionId = guestItem.querySelector(`input[type="hidden"]`).value;
        guestsData[index] = { name: guestName, service_option_id: serviceOptionId };
      });
    }

    guestCount.addEventListener('change', function () {
      const count = parseInt(this.value);
      saveGuestsData();
      renderGuests(count);
    });

    guestList.addEventListener('click', function (e) {
      if (e.target.closest('.remove-guest')) {
        const guestItem = e.target.closest('.guest-item');
        const index = Array.from(guestList.children).indexOf(guestItem);
        guestsData.splice(index, 1);
        guestItem.remove();
        const currentGuests = guestList.querySelectorAll('.guest-item').length;
        guestCount.value = currentGuests;
        renderGuests(currentGuests);
      }
    });

    renderGuests(1);

    // Validation trước submit
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
      let hasError = false;
      guestList.querySelectorAll('.guest-item').forEach(guestItem => {
        const nameInput = guestItem.querySelector('.guest-name');
        const serviceInput = guestItem.querySelector('input[type="hidden"]');
        const errorName = guestItem.querySelector('.error-name');
        const errorService = guestItem.querySelector('.error-service');

        errorName.textContent = '';
        errorService.textContent = '';

        if (!nameInput.value.trim()) {
          errorName.textContent = "{{ __('messages.vuilongnhap') }}";
          hasError = true;
        }

        if (!serviceInput.value) {
          errorService.textContent = "{{ __('messages.chondichvu') }}";
          hasError = true;
        }
      });

      if (hasError) e.preventDefault();
    });

  });
</script>
