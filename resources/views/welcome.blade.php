<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Axios CRUD</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Axios CRUD</h1>
        <hr>
        <div class="row">
            <div class="col-8">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    <tbody id="tbody">


                    </tbody>
                </table>
            </div>
            <div class="col-4">
                <h4>Add New Student</h4>

                <div class="form-group">
                    <input type="text" id="name" placeholder="Add New Student" class="form-control" required>
                    <span class="error" id="text-danger"></span>
                </div>

                <div class="form-group">
                    <center>
                        <button class="btn btn-sm btn-block btn-success" type="submit"
                            style="margin-top: 10px; margin-bottom: 10px;" id="btn">
                            Add New Student</button>
                    </center>
                </div>

            </div>
        </div>
    </div>


    <!-- Modal for view -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Student Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="view-name">
                    <p id="name__"></p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="view-name">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Name:</label>
                            <input type="text" id="e_name" class="form-control" required>
                            <input type="hidden" id="e_id">
                            <span class="error" id="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <center>
                            <button class="btn btn-sm btn-block btn-success" type="submit" id="update_data_btn">
                                Update Student</button>
                        </center>

                    </div>

                </div>


            </div>
        </div>
    </div>


    <script>
        function getAllData() {
            axios.get('/student/get-all-student')
                .then((res) => {
                    // console.log(res.data)
                    let output = document.getElementById("tbody")
                    output.innerHTML = ``
                    res.data.forEach(element => {
                        output.innerHTML +=
                            `
                            <td>${element.id}</td>
                              <td id='data-name'>${element.name}</td>
                               <td>
                              <button class="btn btn-sm btn-primary" id="edit" onclick="editStud(${element.id})" data-toggle="modal" data-target="#editModal">Edit</button>
                              <button class="btn btn-sm btn-success" id="view" onclick="viewStud(${element.id})"  data-toggle="modal" data-target="#viewModal">View</button>
                             <button class="btn btn-sm btn-danger" id="delete" onclick="destroyStud(${element.id})">Delete</button>
                            </td>

                             `
                    })

                })
        }
        window.onload = () => {
            getAllData()
        }


        // store
        document.getElementById('btn').addEventListener("click", addNewDataForm);

        function addNewDataForm() {
            const name = document.getElementById('name').value
            // console.log("button clicked")
            axios.post('/student', {

                    "name": name
                })
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'success',
                        text: 'Data Save Successfully!',
                    })
                    getAllData()
                    // console.log(response)
                })
                .catch(function(error) {
                    console.log(error)
                    // document.getElementById('text-danger').innerText('error')
                });
        };


        // Edit
        function editStud(id) {
            axios.get(`/student/edit/${id}`)
                .then(function(res) {
                    // console.log(response)
                    // console.log(res.data.name)
                    $('#e_name').val(res.data.name)
                    $('#e_id').val(res.data.id)
                    // getAllData()
                })
        }


        // Update

        document.getElementById('update_data_btn').addEventListener("click", UpdateData);

        function UpdateData(id) {

            const _id = document.getElementById("e_id").value
            axios.put(`/student/update/${id}`, {
                    name: $('#e_name').val(),
                    id: _id
                })
                .then(function(res) {
                    document.getElementById('close_button').click();
                    getAllData()
                    // console.log(res)
                })
        }


        // View
        function viewStud(id) {
            axios.get(`/student/edit/${id}`)
                .then(function(res) {
                    // console.log(res.data.name)
                    document.getElementById("name__").textContent = res.data.name

                })
        };



        // delete

        function destroyStud(id) {

            // console.log(response.data)
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger mx-2'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.get(`/student/delete/${id}`)
                        .then(function(response) {
                            getAllData()
                            swalWithBootstrapButtons.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        })

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }

            })
        };
    </script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

    <!-- axios cdn -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>


</body>

</html>
