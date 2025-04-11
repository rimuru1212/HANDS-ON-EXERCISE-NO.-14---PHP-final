$('#frmInsert').submit((e) => {
    e.preventDefault();
    let data = $('#frmInsert').serializeArray();

    $.ajax({
        url : 'index.php?action=register',
        type : 'POST',
        data : {
            data : data
        },
        cache : false,
        success : (response) => {
            Swal.fire(
                'Success!',
                 response,
                'success'
            );
            console.log(response);
            setTimeout( () => {
                window.location.href = 'index.php?action=display'
            }, 1000);
        },
        error : (x, stat, err) => {
            console.log(x);
            console.log(stat);
            console.log(err);
        }
    });
});

$('#frmEdit').submit((e) => {
    e.preventDefault();
    let data = $('#frmEdit').serializeArray();
    $('#exampleModal').modal('hide');

    $.ajax({
        url : 'index.php?action=edit',
        type : 'POST',
        data : {
            data : data
        },
        success : (response) => {
            Swal.fire(
                'Success!',
                 response,
                'success'
            );
          
            setTimeout( () => {
                window.location.href = 'index.php?action=display'
            }, 1000);
        },
        error : (x, stat, err) => {
            console.log(x);
            console.log(stat);
            console.log(err);
        }
    });
});

function edit(id) {
    $.ajax({
        url : 'index.php?action=getStudentData',
        type : 'POST',
        data : {
            id : id
        },
        dataType : 'JSON',
        success : (response) => {
            $('#id').val(response.student_id);
            $('#fname').val(decode(response.student_fname));
            $('#mname').val(decode(response.student_mname));
            $('#lname').val(decode(response.student_lname));
            $('#gender').val(response.student_gender);
            $('#exampleModal').modal('show');
        },
        error : (x, stat, err) => {
            console.log(x);
            console.log(stat);
            console.log(err);
        }
    });
}

function del(id) {
    $.ajax({
        url : 'index.php?action=delete',
        type : 'POST',
        data : {
            id : id
        },
        success : (response) => {
            Swal.fire(
                'Success',
                response,
                'success'
            );

            setTimeout(() => {
                window.location.href = "index.php?action=display"
            }, 1000);

            console.log(response);
        },
        error : (x, stat, err) => {
            console.log(x);
            console.log(stat);
            console.log(err);
        }
    });
}

// to parse or decode html special characters
function decode(str) {
    let txt = new DOMParser().parseFromString(str, "text/html");
    return txt.documentElement.textContent;
}
