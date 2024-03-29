<?php
session_start();
include('config/db.php');
// if(!isset($_SESSION['username']) || !isset($_SESSION['nama']) || !isset($_SESSION['level'])) {
//     session_destroy();
//     header("Location: login.php");
// }

if (isset($_GET['act'])) {
    if ($_GET['act'] == 'logout') {
        session_destroy();
        header("Location: login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal</title>
    <?php include('config/cssjs.php') ?>
</head>

<body class="bg-success-subtle">
    <div>
        <div class="container">
            <h2>Jadwal</h2>
            untuk mengakses Halaman Admin silahkan login > <a href="login.php">Disini</a>
            <hr>
            <form id="main-form" action="" method="post">
                <input type="hidden" name="idhide" value="">
                <input type="hidden" name="act" value="add">
                <!-- <label>Hari</label> -->
                <div class="row">
                    <div class="col-3">
                        <label>Hari</label><br>
                        <!-- <input class="form-control" type="text" name="hari" oninput="getData()"><br><br> -->
                        <?= inputan('', 'hari', 'form-control', 'text', '', 'getData()') ?><br><br>
                    </div>
                    <div class="col-3">
                        <label>Dosen</label><br>
                        <!-- <input class="form-control" type="text" name="dosen" oninput="getData()"><br><br> -->
                        <?= inputan('', 'dosen', 'form-control', 'text', '', 'getData()') ?><br><br>
                    </div>
                    <div class="col-3">
                        <label>Ruang</label><br>
                        <!-- <input class="form-control" type="text" name="ruang" oninput="getData()"><br><br> -->
                        <?= inputan('', 'ruang', 'form-control', 'text', '', 'getData()') ?><br><br>
                    </div>
                    <div class="col-3">
                        <label>Kelas</label><br>
                        <!-- <input class="form-control" type="text" name="ruang" oninput="getData()"><br><br> -->
                        <?= inputan('', 'kelas', 'form-control', 'text', '', 'getData()') ?><br><br>
                    </div>
                </div>
                <!-- <input type="submit" value="Save"> -->
                <input class="btn btn-primary" type="reset" value="Reset">
            </form>
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
            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <td>page</td>
                    <td>:</td>
                    <td><span id="pagenow">1</span> of <span id="totalpage">0</span></td>
                </tr>
                <br>
                <tr>
                    <td>total slot</td>
                    <td>:</td>
                    <td> <span id="totaldatapage">1</span>
                </tr>
            </table>
            <br>
            <div class="row">
                <div class="col-12">
                    <button onclick="getData('first')" class="btn btn-primary">
                        << first</button>
                            <button onclick="getData('prev')" class="btn btn-primary">
                                < prev</button>
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
            let form_hari = document.querySelector(`input[name="hari"]`)
            let form_dosen = document.querySelector(`input[name="dosen"]`)
            let form_ruang = document.querySelector(`input[name="ruang"]`)
            let form_kelas = document.querySelector(`input[name="kelas"]`)
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
                    doAjax("POST", "index-proses.php", data, afterCRUD)
                }
            });

            const deleteData = (idhide) => {
                const tanya = confirm('Yakin?')
                if (!tanya) return
                const data = new FormData(form);
                data.set('act', 'delete')
                data.set('idhide', idhide)
                doAjax("POST", "index-proses.php", data, afterCRUD)
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
                        console.log(xhr)
                        console.log(xhr.responseText)
                        console.log(that)
                        let resp = JSON.parse(xhr.responseText)
                        console.log(resp)
                        let data = resp.data.data
                        tmpdata = data

                        // -- custom -- \\
                        let tbodyhtml = data.map((v, i) => {
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
                                </tr>`
                        })
                        let numberpage = ''
                        for (let i = 1; i <= parseInt(resp.data.total_page); i++) {
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
                if (btn == 'first') {
                    pagenow = 1
                }
                if (btn == 'prev') {
                    if (pagenow > 1) {
                        pagenow = parseInt(pagenow)
                        pagenow -= 1
                    }
                }
                if (btn == 'next') {
                    if (pagenow < totalpage) {
                        pagenow = parseInt(pagenow)
                        pagenow += 1
                    }
                }
                if (btn == 'last') {
                    pagenow = totalpage
                }

                // -- jika number
                const trynumber = parseInt(btn)
                // console.log(trynumber.toString() === 'NaN')
                if (trynumber.toString() !== 'NaN') {
                    pagenow = btn
                }

                // -- send value from form filter
                let urlFilter = "index-proses.php?view=&page=" + pagenow
                urlFilter += '&hari=' + form_hari.value
                urlFilter += '&dosen=' + form_dosen.value
                urlFilter += '&ruang=' + form_ruang.value
                urlFilter += '&kelas=' + form_kelas.value

                const data = new FormData();
                doAjax("GET", urlFilter, data, afterGetData)
            }

            // -- BEHAVIOUR -- \\
            const resetForm = () => {
                setTimeout(function() {
                    document.querySelector('#msg').innerHTML = ''
                }, 5000)

                // form.reset()
                getData()
                // form_act.value = 'add'
            }

            // -- ON FIRST LOAD -- \\
            getData()
        </script>
</body>

</html>