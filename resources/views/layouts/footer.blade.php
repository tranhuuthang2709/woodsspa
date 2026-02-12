<footer style="background-color: #7C3821; color: #fff; padding: 60px 0; position: relative;">
  <div class="container">
    <div class="row align-items-start">
      <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
        <img src="{{ asset('assets/img/lolo.svg') }}" alt="Maha Spa Logo"  class="mb-4">
        <p class="mb-2"><i class="bi bi-geo-alt me-2"></i>{{__('messages.diachi')}}: 126 Hồ Nghinh, Sơn Trà, Đà Nẵng</p>
        <p class="mb-2"><i class="bi bi-telephone me-2"></i>{{__("messages.sdt")}}: 0704061229 - 0905999089</p>
        <p class="mb-3">
          <i class="bi bi-map me-2"></i>
          <a href="https://maps.app.goo.gl/35fHuNYLgS4B9QgQ9" target="_blank" class="text-white text-decoration-underline">
            {{__('messages.bando')}}
          </a>
        </p>

        <p class="mb-2"><i class="bi bi-clock me-2"></i>{{__('messages.thoigianhoatdong')}}: 09:00 – 23:00 {{__('messages.moingay')}}</p>
        <p class="mb-0"><i class="bi bi-envelope me-2"></i>Email: woodsspa126@gmail.com</p>
        <div class="d-flex justify-content-center justify-content-md-start gap-4 mt-4">
          <a href="https://www.instagram.com/woods_spa" target="_blank"><img src="{{ asset('assets/img/instagram.png') }}" alt="Instagram" width="40"></a>
          <a href="https://www.facebook.com/woodsspadanang/" target="_blank"><img src="{{ asset('assets/img/facebook.png') }}" alt="Facebook" width="40"></a>
          <a href="#" target="_blank"><img src="{{ asset('assets/img/line.png') }}" alt="Line" width="40"></a>
          <a href="https://zalo.me/0905999089" target="_blank"><img src="{{ asset('assets/img/zalo.png') }}" alt="Zalo" class="rounded-3" width="40"></a>
        </div>

      </div>

      <div class="col-md-8">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3833.8470595518465!2d108.24012971044887!3d16.073424339261848!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314217861d84a06b%3A0x401b6483858e2e79!2zMTI2IEjhu5MgTmdoaW5oLCBQaMaw4bubYyBN4bu5LCBTxqFuIFRyw6AsIMSQw6AgTuG6tW5n!5e0!3m2!1svi!2s!4v1758979038641!5m2!1svi!2s"
          width="100%" height="400" style="border:0; border-radius:10px;" allowfullscreen>
        </iframe>
      </div>
    </div>
  </div>


  <div class="position-fixed end-0 d-flex flex-column align-items-center gap-3 me-3  d-none d-md-flex "
      style="bottom: 100px; z-index: 1050;">
    <a href="https://www.instagram.com/woods_spa" target="_blank"><img src="{{ asset('assets/img/instagram.png') }}" alt="Instagram" width="45"></a>
    <a href="https://www.facebook.com/woodsspadanang/" target="_blank"><img src="{{ asset('assets/img/facebook.png') }}" alt="Facebook" width="45"></a>
    <a href="#" target="_blank"><img src="{{ asset('assets/img/line.png') }}" alt="Line" width="45"></a>
    <a href="https://zalo.me/0905999089" target="_blank"><img src="{{ asset('assets/img/zalo.png') }}" alt="Zalo" class="rounded-3" width="45"></a>
  </div>

<a href="{{ route('booking.index') }}" 
  id="floatingBookingBtn"
  class="btn fw-semibold d-flex align-items-center gap-2 position-fixed bottom-0 end-0 m-3 px-4 py-2"
  style="
    bottom:20px !important;
    background-color:#733925;
    color:#fff;
    border:none;
    border-radius:12px;
    z-index:1050;
    transition:all 0.35s ease;
    box-shadow:0 4px 10px rgba(70, 41, 41, 0.3);
  ">
  <i class="bi bi-calendar-check"></i> {{ __('messages.datlichngay') }}
</a>


<script>
document.addEventListener("DOMContentLoaded", function () {
  const btn = document.getElementById("floatingBookingBtn");
  const footer = document.querySelector("footer");

  btn.style.boxShadow = "0 8px 25px rgba(0, 0, 0, 0.35)";
  btn.style.transition = "all 0.35s ease";

  btn.addEventListener("mouseenter", () => {
    btn.style.transform = "translateY(-5px)";
    btn.style.boxShadow = "0 12px 35px rgba(0, 0, 0, 0.5)";
  });

  btn.addEventListener("mouseleave", () => {
    btn.style.transform = "translateY(0)";
    btn.style.boxShadow = "0 8px 25px rgba(0, 0, 0, 0.35)";
  });

  window.addEventListener("scroll", () => {
    const footerRect = footer.getBoundingClientRect();
    const windowHeight = window.innerHeight;

    if (footerRect.top < windowHeight) {
      btn.style.transform = "translateY(-10px) scale(1)";
      btn.style.boxShadow = "0 10px 30px rgba(20, 20, 20, 0.5)";
      btn.style.backgroundColor = "#5e2c1c"; 
    } else {
      btn.style.transform = "translateY(0) scale(1)";
      btn.style.boxShadow = "0 8px 25px rgba(20, 20, 20, 0.35)";
      btn.style.backgroundColor = "#733925";
    }
  });

});
</script>


</footer>
