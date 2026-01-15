<?= $this->extend('template/default') ?>

<?= $this->section('content') ?>
<section>
  <div class="container">
    <h1>Input Shearing</h1>

    <div class="print-area">
      <div class="header-form">
        <div class="form-group">
          <label for="date-input">Tanggal</label>
          <input type="date" class="date-input input-1" />
        </div>
        <div class="form-group custom-select">
          <label for="shift">Shift</label>
          <select id="shift" name="shift">
            <button>
              <selectedcontent></selectedcontent>
            </button>

            <option value="" disabled selected hidden>Pilih Shift</option>
            <option value="1">
              <span class="option-label">1</span>
            </option>
            <option value="2">
              <span class="option-label">2</span>
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="mesin">Mesin</label>
          <select id="mesin" name="mesin">
            <button>
              <selectedcontent></selectedcontent>
            </button>

            <option value="" disabled selected hidden>Pilih Mesin</option>
            <option value="Baykal">
              <span class="option-label">Baykal</span>
            </option>
            <option value="Durma">
              <span class="option-label">Durma</span>
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="operator">Operator</label>
          <select id="operator" name="operator">
            <button>
              <selectedcontent></selectedcontent>
            </button>

            <option value="" disabled selected hidden>Operator</option>
            <option value="Seto">
              <span class="option-label">Seto</span>
            </option>
          </select>
        </div>
      </div>

      <div class="material-form">
        <div class="shearing">
          <h2 class="subtitle-1">Raw Material</h2>
          <div class="job-material">
            <div class="form-group">
              <label for="job-number">Job Number</label>
              <select id="job-number" name="job-number">
                <option value="" disabled selected hidden>Pilih Material Number</option>
              </select>
            </div>
            <div class="form-group">
              <label for="material-number">Material Number</label>
              <select id="material-number" name="material-number">
                <option value="" disabled selected hidden>Pilih Material Number</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="mspec">Spesification</label>
            <input type="text" id="mspec" name="mspec" class="spec" placeholder="SPEC" disabled />
          </div>
          <div class="material-qty">
            <div class="form-group">
              <label for="total-sheet">Total Sheet</label>
              <!-- Input User -->
              <input type="text" id="total-sheet" name="total-sheet" class="input-3" placeholder="Total Sheet" />
            </div>
            
            <div class="form-group">
              <label for="customer">Supplier</label>
              <select id="customer" name="customer">
                <option value="" disabled selected hidden>Pilih Supplier</option>
                <option value="SSK">
                  <span class="option-label">SSK</span>
                </option>
                <option value="POSCO">
                  <span class="option-label">POSCO</span>
                </option>
              </select>
            </div>
          </div>
        </div>

        <div class="shearing">
          <h2 class="subtitle-1">Material Hasil Shearing</h2>
          <div class="form-group">
            <label for="shearing-number">Material Number</label>
            <select id="shearing-number" name="shearing-number">
              <option value="" disabled selected hidden>Shearing Number</option>            
            </select>
          </div>
          <div class="form-group">
            <label for="sspec">Spesification</label>
            <input type="text" id="sspec" name="sspec" class="spec" placeholder="SPEC" disabled />
          </div>
          <div class="shearing-qty">
            <div class="form-group">
              <label for="sheet">Sheet</label>
              <!-- Nilainya mengikuti input user -->
              <input type="text" id="sheet" name="sheet" class="input-2" placeholder="Sheet" disabled />
            </div>
            <div class="form-group">
              <label for="bq">BQ</label>
              <input type="text" id="bq" name="bq" class="input-2" placeholder="B/Q" disabled />
            </div>
            <div class="form-group">
              <label for="pcs">PCS</label>
              <input type="text" id="pcs" name="pcs" class="input-2" placeholder="Pcs" disabled />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="buttons">
      <!-- <button class="secondary-btn" onclick="printShearing()">
        Print
      </button> -->
      <button class="primary-btn" id="btnSubmit">
        Submit
      </button>
    </div>
  </div>

  <div id="loadingModal" class="loading-modal">
    <div class="loading-content">
      <div class="spinner"></div>
      <p>Loading...</p>
    </div>
  </div>

  <div id="resultModal" class="modal">
    <div class="modal-content">
      <p style="text-align: center;"><span id="sMessage2"></span>!</p>
      <p style="text-align: center;">Nomor order <span id="sMessage"></span> berhasil dibuat!</p>

      <div class="buttons">
        <button class="primary-btn" onclick="printShearing()">Print</button>
        <button class="secondary-btn" id="closeModal">Tutup</button>
      </div>
    </div>
  </div>

  <div id="errorModal" class="modal">
    <div class="modal-content">
      <h3>⚠️ Error</h3>
      <p id="errorMessage" style="text-align:center"></p>

      <div class="buttons">
        <button class="primary-btn" id="closeErrorModal">OK</button>
      </div>
    </div>
  </div>
</section>

<script>
  const jobMaterialSelect = document.getElementById('job-number');
  const materialSelect = document.getElementById('material-number');
  const specInput = document.getElementById('mspec');
  const resultDiv = document.getElementById('result');
  const shearingSelect = document.getElementById('shearing-number');
  const shearingSpec = document.getElementById('sspec');
  const bqInput = document.getElementById('bq');

  let shearingMap = {};

  showLoading();

  fetch("<?= site_url('/material') ?>")
    .then(res => res.json())
    .then(data => {
      if (!data.success) {
        showError(data.message);
        return;
      }

      const dataMaterial = data.data.ZDT_MTRL2;

      dataMaterial.forEach(item => {
        // const option = document.createElement('option');
        // option.value = item.MATNR;
        // option.textContent = item.MATNR;
        // option.dataset.maktg = item.MAKTG;
        // option.dataset.bismt = item.BISMT;
        // materialSelect.appendChild(option);

        // Material (MATNR)
        const option = new Option(item.MATNR, item.MATNR, false, false);
        option.dataset.maktg = item.MAKTG;
        option.dataset.bismt = item.BISMT;
        materialSelect.appendChild(option);

        // const option2 = document.createElement('option');
        // option2.value = item.BISMT;
        // option2.textContent = item.BISMT;
        // option2.dataset.maktg = item.MAKTG;
        // option2.dataset.matnr = item.MATNR;
        // jobMaterialSelect.appendChild(option2);

        // Job Material (BISMT)
        const option2 = new Option(item.BISMT, item.BISMT, false, false);
        option2.dataset.maktg = item.MAKTG;
        option2.dataset.matnr = item.MATNR;
        jobMaterialSelect.appendChild(option2);
      });

      $('#material-number').select2({
        placeholder: 'Pilih material number',
        width: '100%'
      });

      $('#job-number').select2({
        placeholder: 'Pilih job number',
        width: '100%'
      });
    })
    .catch(err => console.error(err))
    .finally(() => {
      hideLoading();
    });
  
  jobMaterialSelect.addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const bismt = selected.value;
    const maktg = selected.dataset.maktg;
    const matnr = selected.dataset.matnr;

    if (matnr) {
      materialSelect.value = matnr;
    }

    console.log(matnr);

    specInput.value = maktg || '';

    showLoading();

    fetch("<?= site_url('shearing') ?>", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        material: matnr
      })
    })
    .then(res => res.json())
    .then(data => {
      console.log('Data:', data);

      shearingSelect.innerHTML = 
        `<option value="" disabled selected hidden>Pilih Material Number</option>`;
      
      if (data) {
        const option = document.createElement('option');
        option.value = data.MATNR;
        option.textContent = data.MATNR;
        option.selected = true;
        shearingSelect.appendChild(option);
      }

      shearingSpec.value = shearingMap[data.MATNR] || '';

      const menge = data.MENGE ?? '';
      const bqRaw = parseFloat(menge) || 0;
      const bqInt = Math.round(1 / bqRaw);

      bqInput.value = bqInt;
    })
    .catch(err => {
      console.error(err);
    })
    .finally(() => {
      hideLoading();
    });
  })

  materialSelect.addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const matnr = selected.value;
    const maktg = selected.dataset.maktg;
    const bismt = selected.dataset.bismt;

    if (bismt) {
      jobMaterialSelect.value = bismt;
    }

    specInput.value = maktg || '';

    showLoading();

    fetch("<?= site_url('shearing') ?>", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        material: matnr
      })
    })
    .then(res => res.json())
    .then(data => {
      console.log('Data:', data);

      shearingSelect.innerHTML = 
        `<option value="" disabled selected hidden>Pilih Material Number</option>`;
      
      if (data) {
        const option = document.createElement('option');
        option.value = data.MATNR;
        option.textContent = data.MATNR;
        option.selected = true;
        shearingSelect.appendChild(option);
      }

      shearingSpec.value = shearingMap[data.MATNR] || '';

      const menge = data.MENGE ?? '';
      const bqRaw = parseFloat(menge) || 0;
      const bqInt = Math.round(1 / bqRaw);

      bqInput.value = bqInt;
    })
    .catch(err => {
      console.error(err);
    })
    .finally(() => {
      hideLoading();
    })
  });

  $('#material-number').on('select2:select', function (e) {
    const selected = e.params.data.element;

    const matnr = selected.value;
    const maktg = selected.dataset.maktg;
    const bismt = selected.dataset.bismt;

    if (bismt) {
      $('#job-number').val(bismt).trigger('change.select2');
    }

    specInput.value = maktg || '';

    fetchShearing(matnr);
  });

  $('#job-number').on('select2:select', function (e) {
    const selected = e.params.data.element;

    const bismt = selected.value;
    const matnr = selected.dataset.matnr;
    const maktg = selected.dataset.maktg;

    if (matnr) {
      $('#material-number').val(matnr).trigger('change.select2');
    }

    specInput.value = maktg || '';

    fetchShearing(matnr);
  });

  function fetchShearing(matnr) {
    if (!matnr) return;

    showLoading();

    fetch("<?= site_url('shearing') ?>", {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ material: matnr })
    })
    .then(res => res.json())
    .then(data => {
      shearingSelect.innerHTML = 
        `<option value="" disabled selected hidden>Pilih Material Number</option>`;

      if (data) {
        const option = new Option(data.MATNR, data.MATNR, true, true);
        shearingSelect.appendChild(option);

        $('#shearing-number')
          .val(data.MATNR)
          .trigger('change.select2');
      }

      const menge = parseFloat(data.MENGE) || 0;
      bqInput.value = menge ? Math.round(1 / menge) : '';
    })
    .catch(err => console.error(err))
    .finally(() => {
      hideLoading();
    })
  }

  fetch("<?= site_url('spec-shearing') ?>")
    .then(res => res.json())
    .then(data => {
      shearingSelect.innerHTML =
        `<option value="" disabled selected hidden>Pilih Material Number</option>`;

      data.forEach(item => {
        shearingMap[item.MATNR] = item.MAKTG;

        // const option = document.createElement('option');
        // option.value = item.MATNR;
        // option.textContent = item.MATNR;
        // option.selected = true;
        const option = new Option(item.MATNR, item.MATNR, false, false);
        shearingSelect.appendChild(option);
      });

      $('#shearing-number').select2({
        placeholder: 'Pilih material shearing',
        width: '100%'
      });
    });

  $('#shearing-number').on('change.select2', function () {
    const matnr = this.value;
    shearingSpec.value = shearingMap[matnr] || '';
  });

  const totalSheetInput = document.getElementById('total-sheet');
  const sheetInput = document.getElementById('sheet');
  const pcsInput = document.getElementById('pcs');

  function calculatePCS(sheetValue) {
    const sheet = parseInt(sheetValue, 10) || 0;
    const bqInt = bqInput.value;

    pcsInput.value = sheet * bqInt;
  }

  totalSheetInput.addEventListener('input', function () {
    const totalSheet = parseInt(this.value, 10) || 0;
    sheetInput.value = totalSheet;
    calculatePCS(sheetInput.value);
  });

  document.getElementById('btnSubmit').addEventListener('click', () => {
    if(!validateRequiredFields()) {
      return;
    }

    const shearing = shearingSelect.value;
    const shearQtyResult = pcsInput.value;

    if (!shearing) {
      alert('Material belum dipilih!');
      return;
    }

    showLoading();

    fetch("<?= site_url('create-order') ?>", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        shearing: shearing,
        quantity: shearQtyResult
      })
    })
    .then(res => res.json())
    .then(data => {
      openModal(data[0]);
      console.log(data);
    })
    .catch(err => console.error(err))
    .finally(() => {
      hideLoading();
    });
  })

  function extractMatnr(str) {
    if (!str) return;
    return str.replace(/\s*\(.*/, '').trim();
  }

  function extractDimensions(str) {
    if (!str) return;

    const regex = /\(([\d.,]+)\s*mm\s*x\s*(\d+)\s*mm\s*x\s*(\d+)\s*mm\)/i;
    const match = str.match(regex);

    if (!match) return null;

    return {
      thickness: match[1],
      width: match[2],
      length: match[3]
    };
  }

  function printShearing() {
    const rawMaterial = document.getElementById('mspec').value;
    const rawShearMaterial = document.getElementById('sspec').value;

    const materialSpec = extractMatnr(rawMaterial);
    const shearMaterialSpec = extractMatnr(rawShearMaterial);
    
    const { 
      thickness: mThickness, 
      width: mWidth, 
      length: mLength
    } = extractDimensions(rawMaterial);
    const { 
      thickness: sThickness, 
      width: sWidth, 
      length: sLength 
    } = extractDimensions(rawShearMaterial);

    console.log(mThickness);
    console.log(typeof mThickness);

    const params = new URLSearchParams({
      tanggal: document.querySelector('.date-input').value,
      shift: document.getElementById('shift').value,
      mesin: document.getElementById('mesin').value,
      operator: document.getElementById('operator').value,

      material: document.getElementById('material-number').value,
      mspec: materialSpec,
      mThickness: mThickness,
      mWidth: mWidth,
      mLength: mLength,
      sheet: document.getElementById('sheet').value,
      customer: document.getElementById('customer').value,
      bq: document.getElementById('bq').value,
      pcs: document.getElementById('pcs').value,

      shear_material: document.getElementById('shearing-number').value,
      sspec: shearMaterialSpec,
      sThickness: sThickness,
      sWidth: sWidth,
      sLength: sLength,
    });

    window.open("<?= site_url('/print') ?>?" + params.toString(), '_blank');
  }

  function showLoading() {
    document.getElementById('loadingModal').style.display = 'flex';
  }

  function hideLoading() {
    document.getElementById('loadingModal').style.display = 'none';
  }

  function openModal(data) {
    document.getElementById("sMessage").textContent = data.MESSAGE;
    document.getElementById("sMessage2").textContent = data.MESSAGE2;

    document.getElementById("resultModal").style.display = 'block';
  }

  document.getElementById('closeModal').onclick = () => {
    document.getElementById('resultModal').style.display = 'none';
  }

  function validateRequiredFields() {
    const fields = [
      { id: '.date-input', name: 'Tanggal' },
      { id: '#shift', name: 'Shift' },
      { id: '#mesin', name: 'Mesin' },
      { id: '#operator', name: 'Operator' },
      { id: '#job-number', name: 'job-number' },
      { id: '#material-number', name: 'material-number' },
      { id: '#total-sheet', name: 'total-sheet' },
      { id: '#shearing-number', name: 'shearing-number' },
    ];

    for (const field of fields) {
      const el = document.querySelector(field.id);
      if (!el || !el.value || el.value.trim() === '') {
        showError(`❌ ${field.name} wajib diisi`, field.id);
        el?.classList.add('error');
        return false;
      }

      el?.classList.remove('error');
    }

    return true;
  }

  function showError(message, focusSelector = null) {
    document.getElementById('errorMessage').textContent = message;
    document.getElementById('errorModal').style.display = 'block';

    if (focusSelector) {
      setTimeout(() => {
        const el = document.querySelector(focusSelector);
        el?.focus();
      }, 200);
    }
  }

  document.getElementById('closeErrorModal').onclick = () => {
    document.getElementById('errorModal').style.display = 'none';
  };
</script>

<style>
select {
  border: 1px solid #5e6366;
  padding: 8px 16px;
  font-size: 16px;
  font-family: "Outfit", sans-serif;
  border-radius: 8px;
}

.select:hover {
  cursor: pointer;
}

/* Select2 */
.select2-container--default 
.select2-selection--single {
  height: 42px;
  border: 1px solid #5e6366;
  border-radius: 8px;
  padding: 6px 16px;
  font-family: "Outfit", sans-serif;
  font-size: 16px;
  display: flex;
  align-items: center;
  background-color: #fff;
  width: 100%;
}

.select2-container--default 
.select2-selection--single 
.select2-selection__rendered {
  color: #000;
  line-height: normal;
  padding-left: 0;
  padding-right: 0;
}

.select2-container--default 
.select2-selection--single 
.select2-selection__arrow {
  height: 100%;
  right: 0px;
}

.select2-container--default
.select2-selection--single
.select2-selection__placeholder {
  color: #000;
}

.select-container--default.select2-container--focus
.select-selection--single {
  border-color: #5e6366;
  box-shadow: 0 0 0 2px rgba(94, 99, 102, 0.15);
}

.select2-dropdown {
  border: 1px solid #5e6366;
  border-radius: 8px;
  font-family: "Outfit", sans-serif;
  font-size: 16px;
}

.select2-container--default .select2-results__option--highlighted {
  background-color: #5e6366;
  color: #fff;
}

.select2-container--default .select2-results__option--selected {
  background-color: #e5e7eb;
  color: #000;
}
/* Select2 */

input {
  font-size: 16px;
  font-family: "Outfit", sans-serif;
}

input[type="text"] {
  font-size: 16px;
  padding: 8px 16px;
  border-radius: 8px;
  border: 1px solid #5E6366;
}

input[type="text"]:disabled {
  background: #e5e7eb;
}

.container {
  padding: 20px;
  display: flex;
  flex-direction: column;
  gap: 32px;
  max-width: 100%;
  height: 93vh;
}

.print-area {
  display: flex;
  flex-direction: column;
  gap: 32px;
}

.header-form {
  display: flex;
  gap: 40px;
  background: white;
  width: max-content;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.date-input {
  font-size: 16px;
  padding: 8px 16px;
  border-radius: 8px;
  border: 1px solid #5e6366;
}

option {
  display: flex;
  justify-content: flex-start;
  gap: 20px;
  font-family: "Outfit", sans-serif;
}

.material-form {
  display: flex;
  gap: 40px;
}

.job-material {
  display: flex;
  gap: 40px;
  width: 100%;
}

.job-material .form-group {
  flex: 1;
}

.shearing {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 20px;
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
}

.material-qty, .shearing-qty {
  display: flex;
  gap: 20px;
}

.material-qty input, .shearing-qty input {
  max-width: 120px;
}

.buttons {
  display: flex;
  justify-content: center;
  gap: 12px;
}

.primary-btn {
  all: unset;
  background: #1d4ed8;
  padding: 8px 16px;
  color: white;
  border-radius: 4px;
}

.secondary-btn {
  all: unset;
  background: #15803d;
  padding: 8px 16px;
  color: white;
  border-radius: 4px;
}

.primary-btn:hover,
.secondary-btn:hover {
  cursor: pointer;
}

.modal {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,.5);
}

.modal-content {
  display: flex;
  flex-direction: column;
  gap: 12px;
  background: white;
  padding: 20px;
  width: 400px;
  margin: 10% auto;
  border-radius: 8px;
}

.modal-content button {
  width: max-content;
}

.loading-modal {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.4);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.loading-content {
  background: #fff;
  padding: 24px 32px;
  border-radius: 10px;
  text-align: center;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #ddd;
  border-top: 4px solid #4f46e5;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 12px;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>
<?= $this->endSection() ?>
