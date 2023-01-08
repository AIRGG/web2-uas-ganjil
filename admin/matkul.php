<?php
include('cek_auth.php');

$sql_ruang = "SELECT * FROM tbl_ruang";
$sql_kelas = "SELECT * FROM tbl_kelas";
$sql_dosen = "SELECT * FROM tbl_dosen";

$q_ruang = $conn->query($sql_ruang);
$q_kelas = $conn->query($sql_kelas);
$q_dosen = $conn->query($sql_dosen);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <?php include('../config/cssjs-admin.php') ?>
</head>
<body>
<div class="bg-warning-subtle">
<?php include('navbar.php') ?>
<div class="container-fluid">
    <h2>Matkul</h2>
    <form id="main-form" action="" method="post">
        <input type="hidden" name="idhide" value="">
        <input type="hidden" name="act" value="add">
        <label>Dosen</label><br>
        <select name="dosen" required>
            <option value="">-- please select option --</option>
            <?php foreach($q_dosen as $d_dosen): ?>
            <option value="<?= $d_dosen['id_dosen'] ?>"><?= $d_dosen['nip'] ?> | <?= $d_dosen['nama_dosen'] ?></option>
            <?php endforeach ?>
        </select><br><br>
        <label>Kelas</label><br>
        <select name="kelas" required>
            <option value="">-- please select option --</option>
            <?php foreach($q_kelas as $d_kelas): ?>
            <option value="<?= $d_kelas['id_kelas'] ?>"><?= $d_kelas['nama_kelas'] ?></option>
            <?php endforeach ?>
        </select><br><br>
        <label>Ruang</label><br>
        <select name="ruang" required>
            <option value="">-- please select option --</option>
            <?php foreach($q_ruang as $d_ruang): ?>
            <option value="<?= $d_ruang['id_ruang'] ?>"><?= $d_ruang['nama_ruang'] ?></option>
            <?php endforeach ?>
        </select><br><br>
        <label>Hari</label><br>
        <input required type="text" name="hari"><br><br>
        <label>Waktu</label><br>
        <input required type="text" name="waktu"><br><br>
        <label>Matkul</label><br>
        <input required type="text" name="matkul"><br><br>
        <label>JJ</label><br>
        <input required type="text" name="jj"><br><br>
        <label>Tahun Ajaran</label><br>
        <input required type="text" name="ta"><br><br>
        <label>Semester</label><br>
        <input required type="text" name="sem"><br><br>
        <input type="submit" value="Save" class="btn btn-success">
        <input type="reset" value="Reset" class="btn btn-warning">
    </form>
    <br>
    <span id="msg"></span>
    <hr>
    <button onclick="getData()" class="btn btn-primary">Refresh</button><br><br>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <th>No</th>
            <th>Hari</th>
            <th>Slot Waktu</th>
            <th>Mata Kuliah</th>
            <th>Dosen</th>
            <th>Ruang</th>
            <th>Kelas</th>
            <th>JJ</th>
            <th>Tahun Ajaran</th>
            <th>Semester</th>
            <th>Action</th>
        </thead>
        <tbody id="tbody-data">
            <!-- <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>
                    <a href="">Edit</a> | <a href="">Hapus</a>
                </td>
            </tr> -->
        </tbody>
    </table>
    <br>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
        <td>page</td><td>:</td>
        <td><span id="pagenow">1</span> of <span id="totalpage">0</span></td>
        </tr>
        <br>
        <tr>
        <td>total slot</td><td>:</td>
        <td> <span id="totaldatapage">1</span>
        </tr>
        </table>
        <br>
        <div class="row">
            <div class="col-12">
                <button onclick="getData('first')" class="btn btn-primary"><< first</button>
                <button onclick="getData('prev')" class="btn btn-primary">< prev</button>
                <div id="angka-paging" style="display: inline"></div>
                <button onclick="getData('next')" class="btn btn-primary">next ></button>
                <button onclick="getData('last')" class="btn btn-primary">> last</button>
            </div>
        </div>
    </div>

    <script>
        // -- PREPARE VARIABLE --\\
        let form_idhide = document.querySelector(`input[name="idhide"]`)
        let form_act = document.querySelector(`input[name="act"]`)

        //-- custom -- \\
        let form_dosen = document.querySelector(`select[name="dosen"]`)
        let form_kelas = document.querySelector(`select[name="kelas"]`)
        let form_ruang = document.querySelector(`select[name="ruang"]`)
        let form_hari = document.querySelector(`input[name="hari"]`)
        let form_waktu = document.querySelector(`input[name="waktu"]`)
        let form_matkul = document.querySelector(`input[name="matkul"]`)
        let form_jj = document.querySelector(`input[name="jj"]`)
        let form_ta = document.querySelector(`input[name="ta"]`)
        let form_sem = document.querySelector(`input[name="sem"]`)
        //-- [END] custom -- \\

        const tag_pagenow = document.querySelector('#pagenow')
        const tag_totalpage = document.querySelector('#totalpage')
        const tag_totaldatapage = document.querySelector('#totaldatapage')
        const tag_tbodyhtml = document.querySelector('#tbody-data')
        const tag_angkapaginghtml = document.querySelector('#angka-paging')
        let pagenow = 1;
        let nomor = 1;
        let totalpage = 0;
        let totaldatapage = 0;
        let tmpdata = []

        // -- CRUD -- \\
        const form = document.getElementById("main-form");
        form.noValidate = true;
        form.addEventListener('submit', function handleFormSubmit(event) {
            event.preventDefault();
        const isValid = form.reportValidity();
        if (isValid) {
            const data = new FormData(form);
            doAjax("POST", "matkul-proses.php", data, afterCRUD)
        }
        });

        const deleteData = (idhide) => {
            const tanya = confirm('Yakin?')
            if(!tanya) return
            const data = new FormData(form);
            data.set('act', 'delete')
            data.set('idhide', idhide)
            doAjax("POST", "matkul-proses.php", data, afterCRUD)
        }

        const editData = (idhide, idx) => {
            form_idhide.value = idhide
            form_act.value = 'edit'
            let jsndata = tmpdata[idx]

            // -- custom -- \\
            form_dosen.value = jsndata.id_dosen
            form_kelas.value = jsndata.id_kelas
            form_ruang.value = jsndata.id_ruang
            form_hari.value = jsndata.hari
            form_waktu.value = jsndata.waktu
            form_matkul.value = jsndata.matkul
            form_jj.value = jsndata.jj
            form_ta.value = jsndata.ta
            form_sem.value = jsndata.sem

            // form_dosen.dispatchEvent(new Event('change'));
            // form_kelas.dispatchEvent(new Event('change'));
            // form_ruang.dispatchEvent(new Event('change'));
        }

        const afterCRUD = (that, xhr) => {
            if (that.readyState == 4 && that.status == 200) {
                // console.log(xhr.responseText)
                let resp = JSON.parse(xhr.responseText)
                document.querySelector('#msg').innerHTML = resp.msg
                resetForm()
            }
        }

        // -- GET DATA -- \\
        const getData = (btn) => {
            const afterGetData = (that, xhr) => {
                if (that.readyState == 4 && that.status == 200) {
                    // console.log(xhr)
                    // console.log(xhr.responseText)
                    // console.log(that)
                    let resp = JSON.parse(xhr.responseText)
                    console.log(resp)
                    let data = resp.data.data
                    tmpdata = data

                    // -- custom -- \\
                    let tbodyhtml = data.map((v, i)=> {
                        return `<tr>
                                    <td>${resp.data.nomor + (i)}</td>
                                    <td>${v.hari}</td>
                                    <td>${v.waktu}</td>
                                    <td>${v.matkul}</td>
                                    <td>${v.nama_dosen}</td>
                                    <td>${v.nama_ruang}</td>
                                    <td>${v.nama_kelas}</td>
                                    <td>${v.jj}</td>
                                    <td>${v.ta}</td>
                                    <td>${v.sem}</td>
                                    <td>
                                        <button class="btn btn-info" onclick="editData(${v.id_matkul}, ${i})">Edit</button> | <button class="btn btn-danger" onclick="return deleteData(${v.id_matkul})">Hapus</button>
                                    </td>
                                </tr>`
                    })
                    let numberpage = ''
                    for(let i = 1; i <= parseInt(resp.data.total_page); i++) {
                        numberpage += `<button onclick="getData('${i}')" class="btn btn-primary"> ${i} </button>`
                    }
                    // -- [END]custom -- \\
                    tag_tbodyhtml.innerHTML = tbodyhtml.join('')
                    tag_angkapaginghtml.innerHTML = numberpage
                    
                    // paging
                    tag_pagenow.innerHTML = pagenow
                    tag_totalpage.innerHTML = resp.data.total_page
                    tag_totaldatapage.innerHTML = resp.data.jumlah_data
                    nomor = resp.data.nomor
                    totalpage = resp.data.total_page
                    totaldatapage = resp.data.jumlah_data
                }
            }
            // cek paging
            if(btn == 'first') {
                pagenow = 1
            }
            if(btn == 'prev') {
                if(pagenow > 1) {
                    pagenow -= 1
                }
            }
            if(btn == 'next') {
                if(pagenow < totalpage) {
                    pagenow += 1
                }
            }
            if(btn == 'last') {
                pagenow = totalpage
            }

            // -- jika number
            const trynumber = parseInt(btn)
            // console.log(trynumber.toString() === 'NaN')
            if(trynumber.toString() !== 'NaN') {
                pagenow = btn
            }

            const data = new FormData();
            doAjax("GET", "matkul-proses.php?view=&page="+pagenow, data, afterGetData)
        }

        // -- BEHAVIOUR -- \\
        const resetForm = () => {
            setTimeout(function() {
                document.querySelector('#msg').innerHTML = ''
            }, 5000)

            form.reset()
            getData()
            form_act.value = 'add'
        }

        // -- ON FIRST LOAD -- \\
        getData()
    </script>
</body>
</html>