<?php
$active = 'jasa-kirim';
$title = 'Jasa Kirim';

include('partials/header.php');

$sortables = [
  'nama' => 'Nama',
  'harga' => 'Harga',
];

$query = "SELECT * FROM jasa_kirim WHERE nama != 'Lainnya'";

if (isParamsExist(['q'])) {
  $q = htmlspecialchars($_GET['q']);
  $query .= " AND nama LIKE '%$q%'";
}

if (isParamsExist(['sortby'])) {
  if (!array_key_exists($_GET['sortby'], $sortables)) {
    $_GET['sortby'] = 'id';
  } else {
    $sortby = $_GET['sortby'];
  }

  $order = getValidOrder($_GET['order'] ?? 'ASC');
  $query .= " ORDER BY $sortby $order";
} else {
  $query .= " ORDER BY id DESC";
}

$result = $conn->query($query);
$jasa_kirim = $result->fetch_all(MYSQLI_ASSOC);
?>


<style>
  .image-preview:hover {
    opacity: 0.8;
    transition: 0.3s;
    cursor: pointer;
  }

  .image-preview {
    background-color: transparent;
  }

  .btn-action-delete:hover {
    background-color: #e74c3c;
    color: #ffffff;
    transition: 0.3s;
  }
</style>

<div class="page-header d-print-none mt-2">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h3 class="page-title">
          Jasa Kirim
        </h3>
      </div>
      <div class="col-auto ms-auto d-print-none mt-3">
        <div class="btn-list d-flex">
          <a href="tambah-jasa-kirim.php" class="btn btn-primary d-none d-sm-inline-block" id="btnAdd">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M12 5l0 14"></path>
              <path d="M5 12l14 0"></path>
            </svg>
            Tambah Jasa Kirim
          </a>
          <a href="tambah-jasa-kirim.php" class="btn btn-primary d-sm-none btn-icon" data-bs-tooltip="Tambah Jasa Kirim" data-bs-placement="left">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M12 5l0 14"></path>
              <path d="M5 12l14 0"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
    <div class="row g-2 align-items-center">
      <div class="col col-sm-8 col-md-6 col-xl-4 mt-3 d-flex">
        <div class="input-group me-2">
          <input type="text" class="form-control" placeholder="Cari ..." id="inputSearch" value="<?= $_GET['q'] ?? '' ?>">
          <button class="btn btn-icon" type="button" id="btnSearch">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
              <path d="M21 21l-6 -6"></path>
            </svg>
          </button>
        </div>
        <a href="#" class="btn btn-outline-primary btn-icon" data-bs-toggle="modal" data-bs-target="#modal-option">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
          </svg>
        </a>
      </div>
      <?php if (isParamsExist(['q', 'sortby', 'order'])) : ?>
        <div class="col-auto mt-3">
          <a href="jasa-kirim.php" class="btn btn-outline-danger btn-icon" data-bs-toggle="tooltip" data-bs-original-title="Clear filter" data-bs-placement="bottom">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M4 7h16"></path>
              <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
              <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
              <path d="M10 12l4 4m0 -4l-4 4"></path>
            </svg>
          </a>
        </div>
      <?php endif ?>
    </div>
  </div>
</div>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Harga</th>
                  <th class="text-center">Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($jasa_kirim as $index => $item) : ?>
                  <tr class="text-muted">
                    <td>
                      <?= $index + 1 ?>
                    </td>
                    <td>
                      <span <?= add_title_tooltip($item['nama'], 24) ?>>
                        <?= mb_strimwidth($item['nama'], 0, 24, '...') ?>
                      </span>
                    </td>
                    <td>
                      <?= format_rupiah($item['harga']) ?>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <button class="btn btn-icon btn-pill bg-muted-lt" data-bs-toggle="dropdown" aria-expanded="false" title="Lainnya">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dots-vertical" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <circle cx="12" cy="12" r="1">
                            </circle>
                            <circle cx="12" cy="19" r="1">
                            </circle>
                            <circle cx="12" cy="5" r="1">
                            </circle>
                          </svg>
                        </button>
                        <div class="text-muted dropdown-menu dropdown-menu-end">
                          <a class="dropdown-item" href="ubah-jasa-kirim.php?id=<?= $item['id'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none">
                              </path>
                              <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                              </path>
                              <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                              </path>
                              <path d="M16 5l3 3"></path>
                            </svg>
                            Ubah
                          </a>
                          <button class="dropdown-item btn-action-delete" data-id="<?= $item['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalDelete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <line x1="4" y1="7" x2="20" y2="7" />
                              <line x1="10" y1="11" x2="10" y2="17" />
                              <line x1="14" y1="11" x2="14" y2="17" />
                              <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                              <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                            Hapus
                          </button>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>
                <?php if (count($jasa_kirim) == 0) : ?>
                  <tr class="text-center">
                    <td colspan="99">
                      <div class="empty bg-transparent" style="height: 500px;">
                        <div class="empty-img"><img src="<?= asset('images\error\undraw_quitting_time_dm8t.svg') ?>" height="128">
                        </div>
                        <p class="empty-title">Jasa Kirim tidak ditemukan</p>
                        <p class="empty-subtitle text-muted">
                          Coba sesuaikan pencarian atau filter untuk menemukan apa yang anda cari.
                        </p>
                        <div class="empty-action">
                          <a href="jasa-kirim.php" class="btn btn-outline-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none">
                              </path>
                              <path d="M4 7l16 0m-10 4l0 6m4 -6l0 6m-9 -10l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12m-10 0v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3">
                              </path>
                            </svg>
                            Bersihkan filter pencarian
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endif ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Option -->
<div class="modal modal-blur fade" id="modal-option" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Filter Pencarian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="GET" id="formOption">
        <input type="hidden" name="q" id="q">
        <div class="modal-body">
          <div class="row">
            <div class="col-12 mb-3">
              <div class="form-label">Urutkan Berdasarkan</div>
              <select class="form-select" name="sortby">
                <option value="" disabled selected>Pilih</option>
                <?php foreach ($sortables as $key => $value) : ?>
                  <option value="<?= $key ?>" <?= ($_GET['sortby'] ?? '') == $key ? 'selected' : '' ?>>
                    <?= $value ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-12 mb-3">
              <div class="form-label">Urutan</div>
              <div class="form-selectgroup">
                <label class="form-selectgroup-item">
                  <input type="radio" name="order" value="asc" class="form-selectgroup-input" <?= ($_GET['order'] ?? '') == 'asc' ? 'checked' : '' ?>>
                  <span class="form-selectgroup-label">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sort-ascending-letters me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M15 10v-5c0 -1.38 .62 -2 2 -2s2 .62 2 2v5m0 -3h-4"></path>
                      <path d="M19 21h-4l4 -7h-4"></path>
                      <path d="M4 15l3 3l3 -3"></path>
                      <path d="M7 6v12"></path>
                    </svg>
                    Ascending
                  </span>
                </label>
                <label class="form-selectgroup-item">
                  <input type="radio" name="order" value="desc" class="form-selectgroup-input" <?= ($_GET['order'] ?? '') == 'desc' ? 'checked' : '' ?>>
                  <span class="form-selectgroup-label">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sort-descending-letters me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M15 21v-5c0 -1.38 .62 -2 2 -2s2 .62 2 2v5m0 -3h-4"></path>
                      <path d="M19 10h-4l4 -7h-4"></path>
                      <path d="M4 15l3 3l3 -3"></path>
                      <path d="M7 6v12"></path>
                    </svg>
                    Descending
                  </span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btnFormOption">Cari</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Delete -->
<div class="modal modal-blur fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-status bg-danger"></div>
      <div class="modal-body text-center py-4">
        <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
          <path d="M12 9v2m0 4v.01" />
          <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
        </svg>
        <h3>Apakah anda yakin?</h3>
        <div class="text-muted">Data yang dihapus tidak dapat dipulihkan.</div>
      </div>
      <div class="modal-footer">
        <div class="w-100">
          <div class="row">
            <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                Batal
              </a></div>
            <div class="col">
              <form method="post" id="formDelete" action="hapus-jasa-kirim.php">
                <input type="hidden" name="id" value="" id="inputDeleteId">
                <button type="submit" class="btn btn-danger w-100" id="btnDelete">
                  Ya, hapus
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= asset('plugins/tabler/dist/libs/fslightbox/index.js') ?>" defer></script>

<script>
  const formOption = document.getElementById('formOption');
  const btnFormOption = document.getElementById('btnFormOption');

  const inputSearch = document.getElementById('inputSearch');
  const btnSearch = document.getElementById('btnSearch');
  const q = document.getElementById('q');

  btnFormOption.addEventListener('click', submitFormOption);
  btnSearch.addEventListener('click', submitFormOption);
  inputSearch.addEventListener('keyup', function(event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      btnSearch.click();
    }
  });

  function submitFormOption() {
    q.value = inputSearch.value;
    formOption.submit();
  }

  const modalDelete = document.getElementById('modalDelete');

  modalDelete.addEventListener('show.bs.modal', function(event) {
    const inputDeleteId = document.getElementById('inputDeleteId');
    inputDeleteId.value = event.relatedTarget.dataset.id;
  });
</script>

<?php include('partials/footer.php') ?>