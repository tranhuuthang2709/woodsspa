<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> 
<script>
  const now = new Date();
  if (now.getMinutes() > 0 || now.getSeconds() > 0) {
    now.setHours(now.getHours() + 1); 
  }
  now.setMinutes(0);
  now.setSeconds(0);

  flatpickr("#datePicker", {
    dateFormat: "d-m-Y",
    theme: "material_blue",
    disableMobile:true,
    minDate: "today",
    defaultDate: "today",
      onChange: function(selectedDates, dateStr, instance) {
      const todayElement = document.querySelector('.flatpickr-day.today');
      if (todayElement) {
        todayElement.classList.remove('today');
      }
    }

  });
  flatpickr("#timePicker", {
    enableTime: true,
    noCalendar: true,
    disableMobile:true,
    dateFormat: "H:i",
    time_24hr:true,
    minuteIncrement: 5,
    defaultDate:now ,
  });
</script>
<script>
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 4,        
    spaceBetween: 20,
    loop: true,              
    autoplay: {
      delay: 0,              
      disableOnInteraction: false,
    },
    speed: 7000,            
    freeMode: true,          
    freeModeMomentum: false,

    breakpoints: {
      0: { slidesPerView: 1 },
      576: { slidesPerView: 2 },
      992: { slidesPerView: 3 },
      1200: { slidesPerView: 4 }
    }
  });
    window.addEventListener("scroll", function() {
      const nav = document.querySelector(".navbar");
      nav.classList.toggle("scrolled", window.scrollY > 50);
    });
  var phoneInput = document.querySelector("#phone");
  var iti = window.intlTelInput(phoneInput, {
    initialCountry: "vn",
    separateDialCode: true,
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/js/utils.js",
  });

  var countryCodeInput = document.createElement("input");
  countryCodeInput.type = "hidden";
  countryCodeInput.name = "country_code";
  countryCodeInput.id = "countryCode";
  phoneInput.form.appendChild(countryCodeInput);

  var countryNameInput = document.createElement("input");
  countryNameInput.type = "hidden";
  countryNameInput.name = "country_name";
  countryNameInput.id = "countryName";
  phoneInput.form.appendChild(countryNameInput);

  function updateCountryInfo() {
    var countryData = iti.getSelectedCountryData();
    document.querySelector("#countryCode").value = '+' + countryData.dialCode;
    document.querySelector("#countryName").value = countryData.name;
  }

  phoneInput.addEventListener('countrychange', updateCountryInfo);
  updateCountryInfo();




  document.getElementById('search-input').addEventListener('input', function() {
    const searchQuery = document.getElementById('search-input').value;

    if (searchQuery.trim() === '') {
        fetch('/list-services', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('service-list').innerHTML = data.html;
        })
        .catch(error => console.error('Error:', error));
    } else {
        fetch(`/list-services/search?query=${searchQuery}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('service-list').innerHTML = data.html;
        })
        .catch(error => console.error('Error:', error));
    }
});


function initCustomSelect() {
  document.querySelectorAll('.custom-select-wrapper').forEach(wrapper => {
    const select = wrapper.querySelector('select');
    const selected = wrapper.querySelector('.custom-select');
    const optionsContainer = wrapper.querySelector('.custom-options');
    const optionsList = optionsContainer.querySelectorAll('div');

    // Ẩn/hiện dropdown khi click
    selected.addEventListener('click', (e) => {
      optionsContainer.classList.toggle('open');
      e.stopPropagation(); // quan trọng
    });

    // Chọn option
    optionsList.forEach(option => {
      option.addEventListener('click', () => {
        selected.textContent = option.textContent;
        select.value = option.getAttribute('data-value');
        optionsContainer.classList.remove('open');
      });
    });
  });

  // Click ngoài đóng dropdown
  document.addEventListener('click', () => {
    document.querySelectorAll('.custom-options.open').forEach(openDropdown => {
      openDropdown.classList.remove('open');
    });
  });
}

document.addEventListener('DOMContentLoaded', initCustomSelect);

</script>




