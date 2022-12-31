<?php
include('cek_auth.php');

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
    <?php include('navbar.php') ?>
    <h2>Setup Ruang</h2>
    <form id="main-form" action="" method="post">
        <input type="hidden" name="idhide" value="">
        <input type="hidden" name="act" value="add">
        <label>Kode Ruang</label><br>
        <input required type="text" name="kode_ruang"><br><br>
        <label>Nama Ruang</label><br>
        <input required type="text" name="nama_ruang"><br><br>
        <input type="submit" value="Save">
        <input type="reset" value="Reset">
    </form>
    <br>
    <span id="msg"></span>
    <hr>
    <button onclick="getData()">Refresh</button>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <th>No</th>
            <th>Kode Ruang</th>
            <th>Nama Ruang</th>
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
    page: <span id="pagenow">1</span> of <span id="totalpage">0</span>
    <br>
    total: <span id="totaldatapage">1</span>
    <br>
    <button onclick="getData('first')"><< first</button>
    <button onclick="getData('prev')">< prev</button>
    <button onclick="getData('next')">next ></button>
    <button onclick="getData('last')">>> last</button>

    <script>
        // -- PREPARE VARIABLE --\\
        let form_idhide = document.querySelector(`input[name="idhide"]`)
        let form_act = document.querySelector(`input[name="act"]`)

        //-- custom -- \\
        let form_kode_ruang = document.querySelector(`input[name="kode_ruang"]`)
        let form_nama_ruang = document.querySelector(`input[name="nama_ruang"]`)
        //-- [END] custom -- \\

        const tag_pagenow = document.querySelector('#pagenow')
        const tag_totalpage = document.querySelector('#totalpage')
        const tag_totaldatapage = document.querySelector('#totaldatapage')
        const tag_tbodyhtml = document.querySelector('#tbody-data')
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
            doAjax("POST", "setup-ruang-proses.php", data, afterCRUD)
        }
        });

        const deleteData = (idhide) => {
            const tanya = confirm('Yakin?')
            if(!tanya) return
            const data = new FormData(form);
            data.set('act', 'delete')
            data.set('idhide', idhide)
            doAjax("POST", "setup-ruang-proses.php", data, afterCRUD)
        }

        const editData = (idhide, idx) => {
            form_idhide.value = idhide
            form_act.value = 'edit'
            let jsndata = tmpdata[idx]

            // -- custom -- \\
            form_kode_ruang.value = jsndata.kode_ruang
            form_nama_ruang.value = jsndata.nama_ruang
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
                                    <td>${v.kode_ruang}</td>
                                    <td>${v.nama_ruang}</td>
                                    <td>
                                        <button onclick="editData(${v.id_ruang}, ${i})">Edit</button> | <button onclick="return deleteData(${v.id_ruang})">Hapus</button>
                                    </td>
                                </tr>`
                    })
                    // -- [END]custom -- \\
                    tag_tbodyhtml.innerHTML = tbodyhtml.join('')
                    
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

            const data = new FormData();
            doAjax("GET", "setup-ruang-proses.php?view=&page="+pagenow, data, afterGetData)
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