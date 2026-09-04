<script>
document.addEventListener('DOMContentLoaded', function () {

    // =====================================================
    // DROPDOWN CHUNG
    // =====================================================
    function initDropdown(drop) {

        const selected = drop.querySelector('.selected');
        const options = drop.querySelectorAll('.dropdown-list li[data-value]');
        const hiddenInput = drop.querySelector('input[type="hidden"]');

        if (!selected || !hiddenInput) return;

        // Mở / đóng dropdown
        selected.addEventListener('click', function (e) {
            e.stopPropagation();

            // Đóng các dropdown khác
            document.querySelectorAll('.custom-dropdown.active').forEach(item => {
                if (item !== drop) {
                    item.classList.remove('active');
                }
            });

            drop.classList.toggle('active');
        });

        // Chọn option
        options.forEach(function (opt) {

            opt.addEventListener('click', function () {

                selected.textContent = opt.textContent.trim();

                hiddenInput.value = opt.dataset.value;

                drop.classList.remove('active');

                // Nếu là dropdown số khách
                if (hiddenInput.id === 'guestCount') {
                    hiddenInput.dispatchEvent(new Event('change'));
                }
            });

        });
    }


    // =====================================================
    // ĐÓNG DROPDOWN KHI CLICK RA NGOÀI
    // =====================================================
    document.addEventListener('click', function () {

        document.querySelectorAll('.custom-dropdown.active')
            .forEach(function (drop) {
                drop.classList.remove('active');
            });

    });


    // =====================================================
    // KHỞI TẠO DROPDOWN NGOÀI DANH SÁCH KHÁCH
    // =====================================================
    document
        .querySelectorAll('.custom-dropdown:not(.guest-dropdown)')
        .forEach(function (drop) {

            initDropdown(drop);

        });


    // =====================================================
    // GUEST
    // =====================================================
    const guestCount = document.getElementById('guestCount');
    const guestList = document.getElementById('guestList');

    if (!guestCount || !guestList) return;


    // =====================================================
    // MẢNG LƯU DỮ LIỆU KHÁCH
    // =====================================================
    let guestsData = [];


    // =====================================================
    // LẤY OLD DATA TỪ LARAVEL
    // =====================================================
    const oldGuests = @json(old('guests', []));


    // =====================================================
    // TEMPLATE KHÁCH
    // =====================================================
    function guestTemplate(index, guestData = {}) {

        return `
            <div class="card shadow-sm p-3 mb-3 guest-item">

                <!-- HEADER -->
                <div class="d-flex justify-content-between align-items-center mb-2">

                    <h5 class="text-brown fw-bold mb-0">
                        {{ __('messages.tenkhachhang') }} ${index + 1}
                    </h5>

                    <button
                        type="button"
                        class="btn btn-link text-danger p-0 remove-guest"
                        title="Xóa khách"
                    >
                        <i class="bi bi-trash-fill fs-5"></i>
                    </button>

                </div>


                <!-- TÊN KHÁCH -->
                <div class="mb-3">

                    <label class="form-label">
                        {{ __('messages.tenkhachhang') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        class="form-control guest-name"
                        name="guests[${index}][name]"
                        placeholder="{{ __('messages.vuilongnhap') }}"
                        value="${escapeHtml(guestData.name || '')}"
                    >

                    <div class="mt-2 text-danger error-name"></div>

                </div>


                <!-- DỊCH VỤ -->
                <div class="mb-3">

                    <label class="form-label">
                        {{ __('messages.dichvu') }}
                        <span class="text-danger">*</span>
                    </label>

                    <div
                        class="custom-dropdown guest-dropdown"
                        data-name="guests[${index}][service_option_id]"
                    >

                        <div class="selected">
                            ${
                                guestData.service_name
                                || "{{ __('messages.chondichvu') }}"
                            }
                        </div>


                        <ul class="dropdown-list">

                            @foreach($categories as $category)

                                @php
                                    $categoryServices = $services->filter(
                                        fn($s) => $s->category_id == $category->id
                                    );
                                @endphp

                                @if($categoryServices->isNotEmpty())

                                    <li
                                        class="fw-bold text-uppercase px-3 py-2"
                                        style="opacity:0.8;"
                                    >
                                        {{ $category->translated_name }}
                                    </li>

                                    @foreach($categoryServices as $service)

                                        @foreach($service->options as $option)

                                            <li data-value="{{ $option->id }}">
                                                {{ $service->translated_name }}
                                                ({{ $option->duration }}')
                                            </li>

                                        @endforeach

                                    @endforeach

                                @endif

                            @endforeach

                        </ul>


                        <input
                            type="hidden"
                            name="guests[${index}][service_option_id]"
                            value="${escapeHtml(guestData.service_option_id || '')}"
                        >

                        <div class="mt-2 text-danger error-service"></div>

                    </div>

                </div>

            </div>
        `;
    }


    // =====================================================
    // ESCAPE HTML
    // Tránh lỗi khi dữ liệu người dùng chứa ký tự đặc biệt
    // =====================================================
    function escapeHtml(value) {

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    }


    // =====================================================
    // LẤY DỮ LIỆU KHÁCH ĐANG HIỂN THỊ
    // =====================================================
    function saveGuestsData() {

        const currentGuests =
            guestList.querySelectorAll('.guest-item');

        const newGuestsData = [];


        currentGuests.forEach(function (guestItem) {

            const guestName =
                guestItem
                    .querySelector('.guest-name')
                    ?.value || '';


            const serviceInput =
                guestItem.querySelector(
                    'input[name^="guests"][name$="[service_option_id]"]'
                );


            const selected =
                guestItem.querySelector(
                    '.custom-dropdown .selected'
                );


            const serviceValue =
                serviceInput?.value || '';


            const serviceName =
                selected?.textContent.trim() || '';


            newGuestsData.push({

                name: guestName,

                service_option_id: serviceValue,

                service_name: serviceName

            });

        });


        // QUAN TRỌNG:
        // Gán lại toàn bộ mảng thay vì giữ index cũ
        guestsData = newGuestsData;
    }


    // =====================================================
    // CẬP NHẬT SỐ KHÁCH TRÊN DROPDOWN
    // =====================================================
    function updateGuestCountDisplay(count) {

        guestCount.value = count;


        const guestSelected =
            document.querySelector(
                '[data-name="guestCount"] .selected'
            );


        if (guestSelected) {

            guestSelected.textContent = count;

        }

    }


    // =====================================================
    // RENDER DANH SÁCH KHÁCH
    // =====================================================
    function renderGuests(count) {

        // Không cho nhỏ hơn 1
        count = Math.max(1, parseInt(count) || 1);


        // Xóa HTML cũ
        guestList.innerHTML = '';


        // Tạo lại danh sách
        for (let i = 0; i < count; i++) {

            guestList.insertAdjacentHTML(
                'beforeend',
                guestTemplate(
                    i,
                    guestsData[i] || {}
                )
            );

        }


        // Khởi tạo dropdown dịch vụ
        guestList
            .querySelectorAll('.guest-dropdown')
            .forEach(function (drop) {

                initDropdown(drop);


                const hiddenInput =
                    drop.querySelector(
                        'input[type="hidden"]'
                    );


                const selected =
                    drop.querySelector('.selected');


                // Khôi phục dịch vụ đã chọn
                if (
                    hiddenInput &&
                    hiddenInput.value &&
                    selected
                ) {

                    const option =
                        drop.querySelector(
                            `li[data-value="${CSS.escape(hiddenInput.value)}"]`
                        );


                    if (option) {

                        selected.textContent =
                            option.textContent.trim();

                    }

                }

            });


        // Cập nhật số lượng
        updateGuestCountDisplay(count);

    }


    // =====================================================
    // ĐỔI SỐ LƯỢNG KHÁCH
    // =====================================================
    guestCount.addEventListener('change', function () {

        // QUAN TRỌNG:
        // Lưu dữ liệu hiện tại trước khi render lại
        saveGuestsData();


        let count =
            parseInt(this.value) || 1;


        // Nếu tăng số khách
        // guestsData cũ vẫn giữ nguyên
        // khách mới sẽ có dữ liệu rỗng
        if (count > guestsData.length) {

            while (guestsData.length < count) {

                guestsData.push({

                    name: '',

                    service_option_id: '',

                    service_name: ''

                });

            }

        }


        // Nếu giảm số khách
        // chỉ giữ lại số khách cần thiết
        if (count < guestsData.length) {

            guestsData =
                guestsData.slice(0, count);

        }


        renderGuests(count);

    });


    // =====================================================
    // XÓA KHÁCH
    // =====================================================
    guestList.addEventListener('click', function (e) {

        const removeButton =
            e.target.closest('.remove-guest');


        if (!removeButton) return;


        const guestItem =
            removeButton.closest('.guest-item');


        if (!guestItem) return;


        // Không cho xóa nếu chỉ còn 1 khách
        if (
            guestList.querySelectorAll('.guest-item').length <= 1
        ) {

            return;

        }


        // =================================================
        // BƯỚC 1:
        // LƯU TOÀN BỘ DỮ LIỆU ĐANG NHẬP
        // =================================================
        saveGuestsData();


        // =================================================
        // BƯỚC 2:
        // TÌM INDEX CỦA KHÁCH ĐANG XÓA
        // =================================================
        const index =
            Array.from(
                guestList.querySelectorAll('.guest-item')
            ).indexOf(guestItem);


        // Nếu không tìm thấy
        if (index === -1) return;


        // =================================================
        // BƯỚC 3:
        // XÓA KHÁCH KHỎI MẢNG DỮ LIỆU
        // =================================================
        guestsData.splice(index, 1);


        // =================================================
        // BƯỚC 4:
        // SỐ KHÁCH MỚI
        // =================================================
        const currentGuests =
            guestsData.length;


        // =================================================
        // BƯỚC 5:
        // RENDER LẠI
        // =================================================
        renderGuests(currentGuests);

    });


    // =====================================================
    // KHỞI TẠO
    // =====================================================
    if (oldGuests.length > 0) {

        // Laravel có dữ liệu cũ
        guestsData =
            oldGuests.map(function (guest) {

                return {

                    name: guest.name || '',

                    service_option_id:
                        guest.service_option_id || '',

                    service_name: ''

                };

            });


        const count =
            guestsData.length;


        renderGuests(count);

    } else {

        // Không có old data
        guestsData = [

            {

                name: '',

                service_option_id: '',

                service_name: ''

            }

        ];


        renderGuests(1);

    }


    // =====================================================
    // VALIDATE TRƯỚC KHI SUBMIT
    // =====================================================
    document
        .getElementById('bookingForm')
        .addEventListener('submit', function (e) {

            // Lưu dữ liệu cuối cùng trước submit
            saveGuestsData();


            let hasError = false;


            // Xóa lỗi cũ
            guestList
                .querySelectorAll('.guest-item')
                .forEach(function (guestItem) {

                    const nameInput =
                        guestItem.querySelector('.guest-name');


                    const serviceInput =
                        guestItem.querySelector(
                            'input[name^="guests"][name$="[service_option_id]"]'
                        );


                    const errorName =
                        guestItem.querySelector('.error-name');


                    const errorService =
                        guestItem.querySelector('.error-service');


                    // Reset lỗi
                    if (errorName) {
                        errorName.textContent = '';
                    }

                    if (errorService) {
                        errorService.textContent = '';
                    }


                    // =========================================
                    // VALIDATE TÊN
                    // =========================================
                    if (
                        !nameInput ||
                        !nameInput.value.trim()
                    ) {

                        if (errorName) {

                            errorName.textContent =
                                "{{ __('messages.vuilongnhap') }}";

                        }

                        hasError = true;

                    }


                    // =========================================
                    // VALIDATE DỊCH VỤ
                    // =========================================
                    if (
                        !serviceInput ||
                        !serviceInput.value
                    ) {

                        if (errorService) {

                            errorService.textContent =
                                "{{ __('messages.chondichvu') }}";

                        }

                        hasError = true;

                    }

                });


            // Nếu có lỗi → không submit
            if (hasError) {

                e.preventDefault();

            }

        });

});

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const toast = document.getElementById('bookingToast');

    if (!toast) return;

    // Tự động biến mất sau 5 giây
    setTimeout(function () {
        closeBookingToast();
    }, 5000);

});


function closeBookingToast() {

    const toast = document.getElementById('bookingToast');

    if (!toast) return;

    toast.classList.add('hide');

    setTimeout(function () {
        toast.remove();
    }, 350);

}
</script>