      <footer class="footer footer-transparent d-print-none">
        <div class="container-xl">
          <div class="row text-center align-items-center flex-row">
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
              <ul class="list-inline list-inline-dots mb-0">
                <li class="list-inline-item">
                  Copyright &copy; 2023 <span class="fw-bold">Ikuzo Rental</span> All rights reserved.
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script src="<?= asset('plugins/tabler/dist/js/tabler.min.js') ?>" defer></script>

  <script>
    const changeDateTime = () => {
      const dateTimeContainer = document.getElementById('datetime');
      const now = new Date();
      const date = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
      const time = now.toLocaleTimeString('it-IT', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
      dateTimeContainer.innerHTML = `${date} - ${time}`;
    }
    document.addEventListener('DOMContentLoaded', changeDateTime);
    setInterval(changeDateTime, 1000);

    function toastr(status = 'success', title = 'Toast Title', text = 'Toast Text') {
      new Notify({
        status: status,
        title: title,
        text: text,
        effect: 'fade',
        speed: 300,
        showIcon: true,
        showCloseButton: true,
        autoclose: true,
        autotimeout: 3000,
        gap: 20,
        distance: 20,
        type: 3,
        position: 'right top',
      })
    }
  </script>
</body>

</html>
