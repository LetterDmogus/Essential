# Android Studio (Kotlin) + Volley API Guide

This guide is for calling your PHP API from Android Studio using Kotlin + Volley.

## 1. Android Setup

### Internet permission
In `AndroidManifest.xml`:

```xml
<uses-permission android:name="android.permission.INTERNET" />
```

### Volley dependency
In `app/build.gradle`:

```gradle
dependencies {
    implementation("com.android.volley:volley:1.2.1")
}
```

## 2. Base URL

Use one of these:

- Emulator: `http://10.0.2.2/penjualanmobil/`
- Real device (same WiFi): `http://YOUR_PC_IP/penjualanmobil/`

```kotlin
object ApiConfig {
    const val BASE_URL = "http://10.0.2.2/penjualanmobil/"
}
```

## 3. Volley Singleton (Kotlin)

Create `VolleyClient.kt`:

```kotlin
import android.content.Context
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.toolbox.Volley

class VolleyClient private constructor(context: Context) {
    val requestQueue: RequestQueue by lazy {
        Volley.newRequestQueue(context.applicationContext)
    }

    fun <T> addToRequestQueue(req: Request<T>) {
        requestQueue.add(req)
    }

    companion object {
        @Volatile private var INSTANCE: VolleyClient? = null

        fun getInstance(context: Context): VolleyClient {
            return INSTANCE ?: synchronized(this) {
                INSTANCE ?: VolleyClient(context).also { INSTANCE = it }
            }
        }
    }
}
```

## 4. GET Example (Read)

```kotlin
import com.android.volley.Request
import com.android.volley.toolbox.JsonArrayRequest

fun getMobil(context: Context) {
    val url = ApiConfig.BASE_URL + "Tampilmobil.php"

    val request = JsonArrayRequest(
        Request.Method.GET,
        url,
        null,
        { response ->
            // response = JSONArray
            // TODO parse and show to RecyclerView
        },
        { error ->
            android.util.Log.e("API", "GET error: ${error.message}")
        }
    )

    VolleyClient.getInstance(context).addToRequestQueue(request)
}
```

## 5. POST Example (Create / Update / Delete)

Use `StringRequest` for form-data POST:

```kotlin
import android.content.Context
import android.util.Log
import com.android.volley.Request
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import org.json.JSONObject

fun postApi(
    context: Context,
    endpoint: String,
    params: Map<String, String>,
    onResult: (Boolean, String) -> Unit
) {
    val url = ApiConfig.BASE_URL + endpoint

    val request = object : StringRequest(
        Method.POST,
        url,
        Response.Listener { response ->
            // Your APIs can return JSON or plain text
            try {
                val obj = JSONObject(response)
                val status = obj.optInt("status", 0) == 1 || obj.optBoolean("success", false)
                val msg = obj.optString("message", response)
                onResult(status, msg)
            } catch (e: Exception) {
                onResult(true, response) // plain text fallback
            }
        },
        Response.ErrorListener { error ->
            Log.e("API", "POST error: ${error.message}", error)
            onResult(false, error.message ?: "Unknown error")
        }
    ) {
        override fun getParams(): MutableMap<String, String> = params.toMutableMap()
    }

    VolleyClient.getInstance(context).addToRequestQueue(request)
}
```

### Example call: Update Mobil

```kotlin
val params = mapOf(
    "kode_mobil" to "M001",
    "merk" to "Toyota",
    "type" to "Avanza",
    "warna" to "Hitam",
    "harga" to "250000000"
)

postApi(this, "EditMobil.php", params) { ok, msg ->
    android.widget.Toast.makeText(this, msg, android.widget.Toast.LENGTH_SHORT).show()
}
```

### Example call: Delete Kredit

```kotlin
val params = mapOf("kode_kredit" to "K001")

postApi(this, "HapusKredit.php", params) { ok, msg ->
    android.widget.Toast.makeText(this, msg, android.widget.Toast.LENGTH_SHORT).show()
}
```

## 6. Endpoint List

### Read (GET)
- `Tampilmobil.php`
- `Tampilkredit.php`
- `Tampilpaket.php`
- `Tampilpembeli.php`
- `Tampilcicilan.php`
- `Tampilcash.php`

### Create (POST)
- `TambahMobil.php`
- `TambahKredit.php`
- `TambahPaket.php`
- `TambahPembeli.php`
- `TambahCicilan.php`
- `TambahCash.php`

### Update (POST)
- `EditMobil.php`
- `EditKredit.php`
- `EditPaket.php`
- `EditPembeli.php`
- `EditCicilan.php`
- `EditCash.php`

### Delete (POST)
- `HapusMobil.php`
- `HapusKredit.php`
- `HapusPaket.php`
- `HapusPembeli.php`
- `HapusCicilan.php`
- `HapusCash.php`

## 7. Database Structure (Based on Current API)

Below is the table/column structure inferred from your PHP files.

```sql
-- 1) mobil
CREATE TABLE mobil (
  kode_mobil VARCHAR(20) PRIMARY KEY,
  merk VARCHAR(100) NOT NULL,
  type VARCHAR(100) NOT NULL,
  warna VARCHAR(50) NOT NULL,
  harga DECIMAL(15,2) NOT NULL,
  gambar VARCHAR(255) NULL
);

-- 2) pembeli
CREATE TABLE pembeli (
  ktp VARCHAR(30) PRIMARY KEY,
  nama_pembeli VARCHAR(100) NOT NULL,
  alamat_pembeli VARCHAR(255) NOT NULL,
  telp_pembeli VARCHAR(20) NOT NULL
);

-- 3) paket
CREATE TABLE paket (
  kode_paket VARCHAR(20) PRIMARY KEY,
  uang_muka INT NOT NULL,
  tenor INT NOT NULL,
  bunga_cicilan INT NOT NULL
);

-- 4) kredit
CREATE TABLE kredit (
  kode_kredit VARCHAR(20) PRIMARY KEY,
  ktp VARCHAR(30) NOT NULL,
  kode_paket VARCHAR(20) NOT NULL,
  kode_mobil VARCHAR(20) NOT NULL,
  tanggal_kredit DATE NOT NULL,
  bayar_kredit INT NOT NULL,
  tenor INT NOT NULL,
  totalcicil INT NOT NULL,
  FOREIGN KEY (ktp) REFERENCES pembeli(ktp),
  FOREIGN KEY (kode_paket) REFERENCES paket(kode_paket),
  FOREIGN KEY (kode_mobil) REFERENCES mobil(kode_mobil)
);

-- 5) bayar_cicilan
CREATE TABLE bayar_cicilan (
  kode_cicilan VARCHAR(20) PRIMARY KEY,
  kode_kredit VARCHAR(20) NOT NULL,
  tanggal_cicilan DATE NOT NULL,
  cicilanke INT NOT NULL,
  jumlah_cicilan INT NOT NULL,
  sisacicilke INT NOT NULL,
  sisa_cicilan INT NOT NULL,
  FOREIGN KEY (kode_kredit) REFERENCES kredit(kode_kredit)
);

-- 6) beli_cash
CREATE TABLE beli_cash (
  kode_cash VARCHAR(20) PRIMARY KEY,
  ktp VARCHAR(30) NOT NULL,
  kode_mobil VARCHAR(20) NOT NULL,
  cash_tgl DATE NOT NULL,
  cash_bayar DECIMAL(15,2) NOT NULL,
  FOREIGN KEY (ktp) REFERENCES pembeli(ktp),
  FOREIGN KEY (kode_mobil) REFERENCES mobil(kode_mobil)
);
```

## 8. Required Key for Delete

- Mobil: `kode_mobil`
- Kredit: `kode_kredit`
- Paket: `kode_paket`
- Pembeli: `ktp`
- Cicilan: `kode_cicilan`
- Cash: `kode_cash`

## 9. Local Debug

You can test quickly in browser first:

- `http://localhost/penjualanmobil/index.php`

