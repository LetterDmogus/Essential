<?php
// Debug page for API testing only.
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CRUD API Debugger</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background: #f5f7fb;
      color: #1f2937;
    }
    h1, h2 { margin: 8px 0; }
    .card {
      background: #fff;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      padding: 14px;
      margin-bottom: 14px;
    }
    .row {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 8px;
      margin-bottom: 8px;
    }
    input, select, button, textarea {
      width: 100%;
      box-sizing: border-box;
      padding: 8px;
      border: 1px solid #9ca3af;
      border-radius: 6px;
      font-size: 14px;
    }
    textarea { min-height: 120px; font-family: Consolas, monospace; }
    button { cursor: pointer; background: #2563eb; color: #fff; border: none; }
    button.secondary { background: #4b5563; }
    button.warn { background: #b91c1c; }
    pre {
      background: #0b1220;
      color: #dbeafe;
      padding: 10px;
      border-radius: 6px;
      overflow: auto;
      margin-top: 8px;
      font-size: 12px;
    }
    .small { font-size: 12px; color: #4b5563; }
  </style>
</head>
<body>
  <h1>CRUD API Debugger</h1>
  <p class="small">Use this page only for testing your API endpoints locally.</p>

  <div class="card">
    <h2>Quick Read (GET)</h2>
    <div class="row">
      <button type="button" onclick="getApi('Tampilmobil.php', 'out-read')">Read Mobil</button>
      <button type="button" onclick="getApi('Tampilkredit.php', 'out-read')">Read Kredit</button>
      <button type="button" onclick="getApi('Tampilpaket.php', 'out-read')">Read Paket</button>
      <button type="button" onclick="getApi('Tampilpembeli.php', 'out-read')">Read Pembeli</button>
      <button type="button" onclick="getApi('Tampilcicilan.php', 'out-read')">Read Cicilan</button>
      <button type="button" onclick="getApi('Tampilcash.php', 'out-read')">Read Cash</button>
    </div>
    <pre id="out-read">Output will appear here...</pre>
  </div>

  <div class="card">
    <h2>MOBIL</h2>
    <div class="row">
      <input id="m_kode" placeholder="kode_mobil">
      <input id="m_merk" placeholder="merk">
      <input id="m_type" placeholder="type">
      <input id="m_warna" placeholder="warna">
      <input id="m_harga" placeholder="harga">
    </div>
    <div class="row">
      <button type="button" onclick="postApi('TambahMobil.php', {
        kode_mobil: v('m_kode'), merk: v('m_merk'), type: v('m_type'), warna: v('m_warna'), harga: v('m_harga')
      }, 'out-mobil')">Create Mobil</button>
      <button type="button" onclick="postApi('EditMobil.php', {
        kode_mobil: v('m_kode'), merk: v('m_merk'), type: v('m_type'), warna: v('m_warna'), harga: v('m_harga')
      }, 'out-mobil')">Update Mobil</button>
      <button class="warn" type="button" onclick="postApi('HapusMobil.php', {
        kode_mobil: v('m_kode')
      }, 'out-mobil')">Delete Mobil</button>
      <button class="secondary" type="button" onclick="getApi('Tampilmobil.php', 'out-mobil')">Read Mobil</button>
    </div>
    <pre id="out-mobil">Mobil output...</pre>
  </div>

  <div class="card">
    <h2>PAKET</h2>
    <div class="row">
      <input id="p_kode" placeholder="kode_paket">
      <input id="p_uang_muka" placeholder="uang_muka">
      <input id="p_tenor" placeholder="tenor">
      <input id="p_bunga" placeholder="bunga_cicilan">
    </div>
    <div class="row">
      <button type="button" onclick="postApi('TambahPaket.php', {
        kode_paket: v('p_kode'), uang_muka: v('p_uang_muka'), tenor: v('p_tenor'), bunga_cicilan: v('p_bunga')
      }, 'out-paket')">Create Paket</button>
      <button type="button" onclick="postApi('EditPaket.php', {
        kode_paket: v('p_kode'), uang_muka: v('p_uang_muka'), tenor: v('p_tenor'), bunga_cicilan: v('p_bunga')
      }, 'out-paket')">Update Paket</button>
      <button class="warn" type="button" onclick="postApi('HapusPaket.php', {
        kode_paket: v('p_kode')
      }, 'out-paket')">Delete Paket</button>
      <button class="secondary" type="button" onclick="getApi('Tampilpaket.php', 'out-paket')">Read Paket</button>
    </div>
    <pre id="out-paket">Paket output...</pre>
  </div>

  <div class="card">
    <h2>PEMBELI</h2>
    <div class="row">
      <input id="pb_ktp" placeholder="ktp">
      <input id="pb_nama" placeholder="nama_pembeli">
      <input id="pb_alamat" placeholder="alamat_pembeli">
      <input id="pb_telp" placeholder="telp_pembeli">
    </div>
    <div class="row">
      <button type="button" onclick="postApi('TambahPembeli.php', {
        ktp: v('pb_ktp'), nama_pembeli: v('pb_nama'), alamat_pembeli: v('pb_alamat'), telp_pembeli: v('pb_telp')
      }, 'out-pembeli')">Create Pembeli</button>
      <button type="button" onclick="postApi('EditPembeli.php', {
        ktp: v('pb_ktp'), nama_pembeli: v('pb_nama'), alamat_pembeli: v('pb_alamat'), telp_pembeli: v('pb_telp')
      }, 'out-pembeli')">Update Pembeli</button>
      <button class="warn" type="button" onclick="postApi('HapusPembeli.php', {
        ktp: v('pb_ktp')
      }, 'out-pembeli')">Delete Pembeli</button>
      <button class="secondary" type="button" onclick="getApi('Tampilpembeli.php', 'out-pembeli')">Read Pembeli</button>
    </div>
    <pre id="out-pembeli">Pembeli output...</pre>
  </div>

  <div class="card">
    <h2>KREDIT</h2>
    <div class="row">
      <input id="k_kode" placeholder="kode_kredit">
      <input id="k_ktp" placeholder="ktp">
      <input id="k_kode_paket" placeholder="kode_paket">
      <input id="k_kode_mobil" placeholder="kode_mobil">
      <input id="k_tanggal" placeholder="tanggal_kredit (YYYY-MM-DD)">
      <input id="k_bayar" placeholder="bayar_kredit">
      <input id="k_tenor" placeholder="tenor">
      <input id="k_total" placeholder="totalcicil">
    </div>
    <div class="row">
      <button type="button" onclick="postApi('TambahKredit.php', {
        kode_kredit: v('k_kode'), ktp: v('k_ktp'), kode_paket: v('k_kode_paket'),
        kode_mobil: v('k_kode_mobil'), tanggal_kredit: v('k_tanggal'),
        bayar_kredit: v('k_bayar'), tenor: v('k_tenor'), totalcicil: v('k_total')
      }, 'out-kredit')">Create Kredit</button>
      <button type="button" onclick="postApi('EditKredit.php', {
        kode_kredit: v('k_kode'), ktp: v('k_ktp'), kode_paket: v('k_kode_paket'),
        kode_mobil: v('k_kode_mobil'), tanggal_kredit: v('k_tanggal'),
        bayar_kredit: v('k_bayar'), tenor: v('k_tenor'), totalcicil: v('k_total')
      }, 'out-kredit')">Update Kredit</button>
      <button class="warn" type="button" onclick="postApi('HapusKredit.php', {
        kode_kredit: v('k_kode')
      }, 'out-kredit')">Delete Kredit</button>
      <button class="secondary" type="button" onclick="getApi('Tampilkredit.php', 'out-kredit')">Read Kredit</button>
    </div>
    <pre id="out-kredit">Kredit output...</pre>
  </div>

  <div class="card">
    <h2>CICILAN</h2>
    <div class="row">
      <input id="c_kode" placeholder="kode_cicilan">
      <input id="c_kredit" placeholder="kode_kredit">
      <input id="c_tanggal" placeholder="tanggal_cicilan (YYYY-MM-DD)">
      <input id="c_ke" placeholder="cicilanke">
      <input id="c_jumlah" placeholder="jumlah_cicilan">
      <input id="c_sisa_ke" placeholder="sisacicilke">
      <input id="c_sisa" placeholder="sisa_cicilan">
    </div>
    <div class="row">
      <button type="button" onclick="postApi('TambahCicilan.php', {
        kode_cicilan: v('c_kode'), kode_kredit: v('c_kredit'), tanggal_cicilan: v('c_tanggal'),
        cicilanke: v('c_ke'), jumlah_cicilan: v('c_jumlah'), sisacicilke: v('c_sisa_ke'), sisa_cicilan: v('c_sisa')
      }, 'out-cicilan')">Create Cicilan</button>
      <button type="button" onclick="postApi('EditCicilan.php', {
        kode_cicilan: v('c_kode'), kode_kredit: v('c_kredit'), tanggal_cicilan: v('c_tanggal'),
        cicilanke: v('c_ke'), jumlah_cicilan: v('c_jumlah'), sisacicilke: v('c_sisa_ke'), sisa_cicilan: v('c_sisa')
      }, 'out-cicilan')">Update Cicilan</button>
      <button class="warn" type="button" onclick="postApi('HapusCicilan.php', {
        kode_cicilan: v('c_kode')
      }, 'out-cicilan')">Delete Cicilan</button>
      <button class="secondary" type="button" onclick="getApi('Tampilcicilan.php', 'out-cicilan')">Read Cicilan</button>
    </div>
    <pre id="out-cicilan">Cicilan output...</pre>
  </div>

  <div class="card">
    <h2>CASH</h2>
    <div class="row">
      <input id="ca_kode" placeholder="kode_cash">
      <input id="ca_ktp" placeholder="ktp">
      <input id="ca_mobil" placeholder="kode_mobil">
      <input id="ca_tgl" placeholder="cash_tgl (YYYY-MM-DD)">
    </div>
    <div class="row">
      <button type="button" onclick="postApi('TambahCash.php', {
        kode_cash: v('ca_kode'), ktp: v('ca_ktp'), kode_mobil: v('ca_mobil'), cash_tgl: v('ca_tgl')
      }, 'out-cash')">Create Cash</button>
      <button type="button" onclick="postApi('EditCash.php', {
        kode_cash: v('ca_kode'), ktp: v('ca_ktp'), kode_mobil: v('ca_mobil'), cash_tgl: v('ca_tgl')
      }, 'out-cash')">Update Cash</button>
      <button class="warn" type="button" onclick="postApi('HapusCash.php', {
        kode_cash: v('ca_kode')
      }, 'out-cash')">Delete Cash</button>
      <button class="secondary" type="button" onclick="getApi('Tampilcash.php', 'out-cash')">Read Cash</button>
    </div>
    <pre id="out-cash">Cash output...</pre>
  </div>

  <div class="card">
    <h2>Manual Endpoint Tester</h2>
    <div class="row">
      <input id="manual_endpoint" placeholder="Endpoint, e.g. EditMobil.php">
      <select id="manual_method">
        <option value="GET">GET</option>
        <option value="POST">POST</option>
      </select>
      <button type="button" onclick="manualSend()">Send</button>
    </div>
    <textarea id="manual_json" placeholder='JSON body for POST, example: {"kode_mobil":"M001","merk":"Honda"}'></textarea>
    <pre id="out-manual">Manual output...</pre>
  </div>

  <script>
    function v(id) {
      return document.getElementById(id).value.trim();
    }

    function show(outId, data) {
      const el = document.getElementById(outId);
      if (typeof data === "string") {
        el.textContent = data;
      } else {
        el.textContent = JSON.stringify(data, null, 2);
      }
    }

    async function getApi(endpoint, outId) {
      try {
        const res = await fetch(endpoint, { method: "GET" });
        const text = await res.text();
        try {
          show(outId, JSON.parse(text));
        } catch (e) {
          show(outId, text);
        }
      } catch (err) {
        show(outId, "GET error: " + err.message);
      }
    }

    async function postApi(endpoint, payload, outId) {
      try {
        const body = new URLSearchParams(payload).toString();
        const res = await fetch(endpoint, {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: body
        });
        const text = await res.text();
        try {
          show(outId, JSON.parse(text));
        } catch (e) {
          show(outId, text);
        }
      } catch (err) {
        show(outId, "POST error: " + err.message);
      }
    }

    async function manualSend() {
      const endpoint = v("manual_endpoint");
      const method = v("manual_method");
      const outId = "out-manual";
      if (!endpoint) {
        show(outId, "Endpoint is required");
        return;
      }

      if (method === "GET") {
        getApi(endpoint, outId);
        return;
      }

      let payload = {};
      const raw = v("manual_json");
      if (raw) {
        try {
          payload = JSON.parse(raw);
        } catch (e) {
          show(outId, "Invalid JSON body");
          return;
        }
      }
      postApi(endpoint, payload, outId);
    }
  </script>
</body>
</html>
