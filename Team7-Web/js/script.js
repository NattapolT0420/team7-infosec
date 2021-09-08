$(function() {
    check_permission();
    $("#permission").css("display", "block");
});

document.addEventListener("DOMContentLoaded", function(event) {

    const showNavbar = (toggleId, navId, bodyId, headerId) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodyindex = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId)

        // Validate that all variables exist
        if (toggle && nav && bodyindex && headerpd) {
            toggle.addEventListener('click', () => {
                // show navbar
                nav.classList.toggle('show');
                // change icon
                toggle.classList.toggle('bx-x');
                // add padding to body
                bodyindex.classList.toggle('body');
                // add padding to header
                headerpd.classList.toggle('body');
                // Username
                $("#username").slideToggle("slow");
                // Role
                $("#role").slideToggle("slow");
            })
        }
    }

    showNavbar('header-toggle', 'nav-bar', 'bodyindex', 'header');

    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link')

    function colorLink() {
        if (linkColor) {
            linkColor.forEach(l => l.classList.remove('active'))
            this.classList.add('active')
        }
    }
    linkColor.forEach(l => l.addEventListener('click', colorLink))

    // Your code to run since DOM is loaded and ready
});

$('.nav_list').find('a').click(function(event) {
    // console.log(event.currentTarget.innerText);
    $('.header_title').html(event.currentTarget.innerText);
    $(".header_input").css("display", "none");
    if (event.currentTarget.innerText == "จัดการรายวิชา") {
        $(".course").css("display", "flex");
    } else if (event.currentTarget.innerText == "คำร้องขอเพิ่ม\n/ ถอนรายวิชา") {
        $(".petition_course").css("display", "flex");
    }

    if ($('.header_back').css("display") == "flex") {
        $('.header_back').css("display", "none");
        $('.tab-pane.active').prop('classList').remove('active');
        if ($('#input_grade_student').val() != "") {
            $('#petition_grade').prop('classList').add('active');
        } else if ($('#input_petition_grade_student').val() != "") {
            $('#petition').prop('classList').add('active');
        }
    }
    if ($('.header_title').css("display") == "none") {
        $('.header_title').css("display", "flex");
    }

    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
    setTimeout(function() {
        if ($(window).height() > document.body.scrollHeight) {
            $('HTML').height($(window).height());
            // alert("window");
        } else {
            $('HTML').height($(document).height());
            // alert("document");
        }
    }, 100);
});

function check_permission() {
    $('#permission').find('a').hide();
    $.ajax({
        url: "role.php?method=check_permission",
        type: "post",
        data: {
            role_name: $('#input_role_name').val(),
        },
        success: function(permission_arr) {
            // console.log(permission_arr);
            if (permission_arr != 'nopermission') {
                const permission = JSON.parse(permission_arr);
                // console.log(permission);
                const no_permission = [];
                $('#permission').find('a').each(function(index) {
                    $.each(permission, function(key, val) {
                        // console.log(val);
                        if (val == $('#permission').find('a').eq(index).attr('data')) {
                            $('#permission').find('a').eq(index).show();
                        } else {
                            no_permission.push($('#permission').find('a').eq(index));
                        }
                    });
                });
            }
        }
    });
}

function edit_role($roleid) {
    $.ajax({
        url: "role.php?method=select_permission",
        type: "post",
        data: {
            role_id: $roleid
        },
        // dataType: "json",
        success: function(permission_json) {
            // console.log(permission_json);
            if (permission_json != 'nopermission') {
                // console.log(permission_json);
                const permission = JSON.parse(JSON.parse(permission_json));
                // console.log(permission);
                $('[name=check_permission]').map(function(index, event) {
                    // console.log(index);
                    $.each(permission, function(key, val) {
                        // console.log(val);
                        if (val == $('[name=check_permission]:eq(' + index + ')').val()) {
                            // console.log($('[name=check_permission]:eq(' + index + ')').val());
                            $('[name=check_permission]:eq(' + index + ')').prop('checked', true);
                        }
                    });
                });
            }
            $('#roleModal').modal('show');
            $('#role_id').val($roleid);
        }
    });
}

$("#role-form").submit(function(event) {
    event.preventDefault();
    const permission = {};
    $('[name=check_permission]:checked').each(function(i) {
        permission["permission" + (i + 1)] = $('[name=check_permission]:checked:eq(' + i + ')').val();
    });
    // console.log(permission);
    // console.log($('#role_id').val());
    $.ajax({
        url: "role.php?method=save_permission",
        type: "post",
        data: {
            role_id: $('#role_id').val(),
            permission: permission,
        },
        success: function(response) {
            // console.log(response);
            if (response == "success") {
                Swal.fire({
                    title: 'บันทึกสำเร็จ',
                    icon: 'success',
                    confirmButtonColor: '#27AE60',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                    $('#roleModal').modal('hide');
                    check_permission();
                })
            } else if (response == "fail") {
                Swal.fire({
                    title: 'ไม่สามารถบันทึกได้',
                    icon: 'error',
                    confirmButtonColor: '#FF2557',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                    $('#roleModal').modal('hide');
                })
            }
        }
    });
});

$('#roleModal').on('hidden.bs.modal', function() {
    $('[name=check_permission]').map(function(index, event) {
        $('[name=check_permission]:eq(' + index + ')').prop('checked', false);
    });
});

function edit_list($id) {
    $.ajax({
        url: "list.php?method=select_list",
        type: "post",
        data: {
            id: $id
        },
        success: function(result) {
            $('#list_id').val($id);
            // console.log(result);
            const list = JSON.parse(result);
            // console.log(list['userid']);
            $('#list_userid').val(list['userid']);
            $('#list_name').val(list['name']);
            if (list['role_id'] == 2) {
                $('#txtuserid').html('รหัสประจำตัวผู้สอน :');
            } else if (list['role_id'] == 3 || list['role_id'] == 4) {
                $('#txtuserid').html('รหัสประจำตัวนักเรียน :');
            }
            $(".alert-danger").css("display", "none");
            $('#listModal').modal('show');
        }
    });
}

$("#list-form").submit(function(event) {
    event.preventDefault();
    // console.log($('#list_id').val());
    $.ajax({
        url: "list.php?method=save_list",
        type: "post",
        data: {
            id: $('#list_id').val(),
            userid: $('#list_userid').val(),
            name: $('#list_name').val(),
        },
        success: function(response) {
            console.log(response);
            if (response == "already") {
                console.log("already");
                $(".alert-danger").css("display", "flex");
                $(".error").html('รหัสประจำตัวนี้มีอยู่ในระบบแล้ว');
            } else if (response == "success") {
                Swal.fire({
                    title: 'บันทึกสำเร็จ',
                    icon: 'success',
                    confirmButtonColor: '#27AE60',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                    $('#listModal').modal('hide');

                })
            } else if (response == "fail") {
                Swal.fire({
                    title: 'ไม่สามารถบันทึกได้',
                    icon: 'error',
                    confirmButtonColor: '#FF2557',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                    $('#listModal').modal('hide');
                })
            }
        }
    });
});

function del_list($id) {
    Swal.fire({
        title: 'คุณแน่ใจแล้วหรือไม่',
        text: "หากลบไปแล้วจะไม่สามารถเรียกข้อมูลกลับมาได้",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#999999',
        confirmButtonColor: '#d33',
        cancelButtonText: 'ไม่',
        confirmButtonText: 'ใช่',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            // console.log("Yes");
            $.ajax({
                url: "list.php?method=del_list",
                type: "post",
                data: {
                    id: $id
                },
                success: function(response) {
                    if (response == "success") {
                        Swal.fire({
                            title: 'ลบสำเร็จ',
                            icon: 'success',
                            confirmButtonColor: '#27AE60',
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {
                            $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                        })
                    } else if (response == "fail") {
                        Swal.fire({
                            title: 'ไม่สามารถลบได้',
                            icon: 'error',
                            confirmButtonColor: '#FF2557',
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {
                            $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                        })
                    }
                }
            });
        }
    })
}

function log_list($id) {
    $.ajax({
        url: "list.php?method=log_list",
        method: "post",
        data: {
            id: $id
        },
        success: function(datalog) {
            // console.log(datalog);
            $('#loglistBody').html(datalog);
            $('#listlogModal').modal('show');
        }
    });
}

function add_course() {
    $.ajax({
        url: "manage_course.php?method=insert_course",
        method: "post",
        data: {
            course_id: $('#course_id').val(),
            course_name: $('#course_name').val(),
            course_teacher: $('#course_teacher').val(),
            course_credit: $('#course_credit').val()
        },
        success: function(response) {
            // console.log(response);
            if (response == "success") {
                Swal.fire({
                    title: 'เพิ่มวิชาสำเร็จ',
                    icon: 'success',
                    confirmButtonColor: '#27AE60',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('#course_id').val("");
                    $('#course_name').val("");
                    $('#course_teacher').val("");
                    $('#course_credit').val("");
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            } else if (response == "again") {
                Swal.fire({
                    title: 'วิชานี้มีอยู่แล้ว',
                    icon: 'error',
                    confirmButtonColor: '#FF2557',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('#course_id').val("");
                    $('#course_name').val("");
                    $('#course_teacher').val("");
                    $('#course_credit').val("");
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            }
        }
    })
}

function edit_course($id) {
    $.ajax({
        url: "manage_course.php?method=select_course",
        type: "post",
        data: {
            id: $id
        },
        success: function(result) {
            $('#table_course_id').val($id);
            // console.log(result);
            const course = JSON.parse(result);
            // console.log(course['course_id']);
            $('#edit_course_id').val(course['course_id']);
            $('#edit_course_name').val(course['course_name']);
            $('#edit_course_credit').val(course['course_credit']);
            $('#edit_course_teacher').val(course['course_teacher']);
            $(".alert-danger").css("display", "none");
            $('#courseModal').modal('show');
        }
    });
}

$("#course-form").submit(function(event) {
    event.preventDefault();
    // console.log($('#table_course_id').val());
    $.ajax({
        url: "manage_course.php?method=save_course",
        type: "post",
        data: {
            id: $('#table_course_id').val(),
            course_id: $('#edit_course_id').val(),
            course_name: $('#edit_course_name').val(),
            course_credit: $('#edit_course_credit').val(),
            course_teacher: $('#edit_course_teacher').val(),
        },
        success: function(response) {
            // console.log(response);
            if (response == "already") {
                // console.log("already");
                $(".alert-danger").css("display", "flex");
                $(".error").html('วิชานี้มีอยู่ในระบบแล้ว');
            } else if (response == "success") {
                Swal.fire({
                    title: 'บันทึกสำเร็จ',
                    icon: 'success',
                    confirmButtonColor: '#27AE60',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                    $('#courseModal').modal('hide');

                })
            } else if (response == "fail") {
                Swal.fire({
                    title: 'ไม่สามารถบันทึกได้',
                    icon: 'error',
                    confirmButtonColor: '#FF2557',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                    $('#courseModal').modal('hide');
                })
            }
        }
    });
});

function del_course($id) {
    Swal.fire({
        title: 'คุณแน่ใจแล้วหรือไม่',
        text: "หากลบไปแล้วจะไม่สามารถเรียกข้อมูลกลับมาได้",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#999999',
        confirmButtonColor: '#d33',
        cancelButtonText: 'ไม่',
        confirmButtonText: 'ใช่',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "manage_course.php?method=del_course",
                type: "post",
                data: {
                    id: $id
                },
                success: function(response) {
                    if (response == "success") {
                        Swal.fire({
                            title: 'ลบสำเร็จ',
                            icon: 'success',
                            confirmButtonColor: '#27AE60',
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {
                            $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                        })
                    } else if (response == "fail") {
                        Swal.fire({
                            title: 'ไม่สามารถลบได้',
                            icon: 'error',
                            confirmButtonColor: '#FF2557',
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {
                            $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                        })
                    }
                }
            });
        }
    })
}

function log_course($id) {
    $.ajax({
        url: "manage_course.php?method=log_course",
        method: "post",
        data: {
            id: $id
        },
        success: function(datalog) {
            // console.log(datalog);
            $('#logcourseBody').html(datalog);
            $('#courselogModal').modal('show');
        }
    });
}

function add_petition_course() {
    $.ajax({
        url: "manage_petition_course.php?method=add_petition_course",
        type: "post",
        data: {
            course_id: $('#select_petition_course').val(),
        },
        success: function(response) {
            // console.log(response);
            if (response == "success") {
                Swal.fire({
                    title: 'เพิ่มวิชาสำเร็จ',
                    icon: 'success',
                    confirmButtonColor: '#27AE60',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('#select_petition_course').val("");
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            } else if (response == "again") {
                Swal.fire({
                    title: 'วิชานี้มีอยู่แล้ว',
                    icon: 'error',
                    confirmButtonColor: '#FF2557',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('#select_petition_course').val("");
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            } else if (response == "grade") {
                Swal.fire({
                    title: 'ไม่สามารถเพิ่มวิชานี้ได้เนื่องจากส่งเกรดแล้ว',
                    icon: 'error',
                    confirmButtonColor: '#FF2557',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('#select_petition_course').val("");
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            }
        }
    })
}

function approve_petition_course($id) {
    $.ajax({
        url: "manage_petition_course.php?method=approve_petition_course",
        type: "post",
        data: {
            id: $id
        },
        success: function(response) {
            // console.log(response);
            if (response == "success") {
                Swal.fire({
                    title: 'อนุมัติสำเร็จ',
                    icon: 'success',
                    confirmButtonColor: '#27AE60',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            } else if (response == "fail") {
                Swal.fire({
                    title: 'ไม่สามารถอนุมัติได้',
                    icon: 'error',
                    confirmButtonColor: '#FF2557',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            }
        }
    })
}

function disapproved_petition_course($id) {
    $.ajax({
        url: "manage_petition_course.php?method=disapproved_petition_course",
        type: "post",
        data: {
            id: $id
        },
        success: function(response) {
            // console.log(response);
            if (response == "success") {
                Swal.fire({
                    title: 'ตรวจคำร้องสำเร็จ',
                    icon: 'success',
                    confirmButtonColor: '#27AE60',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            } else if (response == "fail") {
                Swal.fire({
                    title: 'ไม่สามารถทำรายการได้',
                    icon: 'error',
                    confirmButtonColor: '#FF2557',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            }
        }
    })
}

function del_petition_course($id) {
    Swal.fire({
        title: 'คุณแน่ใจที่จะถอนวิชานี้แล้วหรือไม่',
        text: "หากถอนไปแล้วจะไม่สามารถเรียกข้อมูลกลับมาได้",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#999999',
        confirmButtonColor: '#d33',
        cancelButtonText: 'ไม่',
        confirmButtonText: 'ใช่',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "manage_petition_course.php?method=del_petition_course",
                type: "post",
                data: {
                    id: $id
                },
                success: function(response) {
                    // console.log(response);
                    if (response == "success") {
                        Swal.fire({
                            title: 'ถอนวิชาสำเร็จ',
                            icon: 'success',
                            confirmButtonColor: '#27AE60',
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {
                            $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                        })
                    } else if (response == "fail") {
                        Swal.fire({
                            title: 'ไม่สามารถถอนวิชาได้',
                            icon: 'error',
                            confirmButtonColor: '#FF2557',
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {
                            $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                        })
                    }
                }
            });
        }
    })
}

function grade($id) {
    // console.log($course_id);
    $.ajax({
        url: "manage_petition_course.php?method=petition_course_name",
        type: "post",
        data: {
            id: $id
        },
        success: function(response) {
            // console.log(response);
            const course = JSON.parse(response);
            // console.log(course['course_id']);
            $('.tab-pane.active').prop('classList').remove('active');
            $('#petition_grade_student').prop('classList').add('active');
            $('#input_grade_student').val(course['course_id']);
            setTimeout(function() {
                $('.table_grade_student').bootstrapTable('refresh');
            }, 100);
            $('.header_title_grade').html(course['course_name']);
            $('.header_back').css("display", "flex");
            $('.header_title').css("display", "none");
            $(".petition_grade").css("display", "flex");
        }
    })
}

// function grade_again($id) {
//     // console.log($course_id);
//     $.ajax({
//         url: "manage_petition_course.php?method=petition_course_name",
//         type: "post",
//         data: {
//             id: $id
//         },
//         success: function(response) {
//             // console.log(response);
//             const course = JSON.parse(response);
//             // console.log(course['course_id']);
//             $('.tab-pane.active').prop('classList').remove('active');
//             $('#petition_grade_student').prop('classList').add('active');
//             $('#input_grade_student').val(course['course_id']);
//             setTimeout(function() {
//                 $('.table_grade_student').bootstrapTable('refresh');
//             }, 100);
//             $('.header_title_grade').html(course['course_name']);
//             $('.header_back').css("display", "flex");
//             $('.header_title').css("display", "none");
//             $(".petition_grade").css("display", "flex");
//         }
//     })
// }

function searchQueryParams(params) {
    params.course_id = $('#input_grade_student').val();
    params.grade_id = $('#input_petition_grade_student').val();

    return params;
}

function header_back() {
    // console.log($('#input_grade_student').val());
    // console.log($('#input_petition_grade_student').val());
    if ($('#input_grade_student').val() != "") {
        $('.tab-pane.active').prop('classList').remove('active');
        $('#petition_grade').prop('classList').add('active');
        $(".petition_grade").css("display", "none");
        // console.log($('#input_grade_student').val());
    } else if ($('#input_petition_grade_student').val() != "") {
        $('.tab-pane.active').prop('classList').remove('active');
        $('#petition').prop('classList').add('active');
        $(".petition_check_grade").css("display", "none");
        // console.log($('#input_petition_grade_student').val());
    }
    if ($('.header_back').css("display") == "flex") {
        $('.header_back').css("display", "none");
    }
    if ($('.header_title').css("display") == "none") {
        $('.header_title').css("display", "flex");
    }
}

function send_petition_grade() {
    // console.log("Send Grade");
    const grade_student = {};
    $('.tab-pane.active').find('.grade').each(function(index) {
        grade_student[$(this).attr('data-id')] = $(this).val();
    });
    // console.log(grade_student);
    // console.log($('#input_petition_grade_student').val());
    $.ajax({
        url: "manage_grade.php?method=insert_grade",
        method: "post",
        data: {
            course_id: $('#input_grade_student').val(),
            grade_student: grade_student,
        },
        success: function(response) {
            console.log(response);
            if (response == "success") {
                Swal.fire({
                    title: 'ส่งคำร้องสำเร็จ',
                    icon: 'success',
                    confirmButtonColor: '#27AE60',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    header_back();
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            } else if (response == "fail") {
                Swal.fire({
                    title: 'ไม่สามารถส่งคำร้องได้',
                    icon: 'error',
                    confirmButtonColor: '#FF2557',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            }
        }
    })
}

function petition_grade($grade_id) {
    // console.log($grade_id);
    $.ajax({
        url: "manage_grade.php?method=petition_grade",
        type: "post",
        data: {
            grade_id: $grade_id
        },
        success: function(response) {
            // console.log(response);
            const grade = JSON.parse(response);
            // console.log(grade['course_name']);
            $('.tab-pane.active').prop('classList').remove('active');
            $('#petition_grade_student').prop('classList').add('active');
            $('#input_petition_grade_student').val($grade_id);
            setTimeout(function() {
                $('.table_grade_student').bootstrapTable('refresh');
            }, 100);
            $('.header_title_grade').html(grade['course_name']);
            $('.header_back').css("display", "flex");
            $('.header_title').css("display", "none");
            $(".petition_check_grade").css("display", "flex");
        }
    })
}

function approve_petition_grade() {
    $.ajax({
        url: "manage_grade.php?method=approve_grade",
        type: "post",
        data: {
            grade_id: $('#input_petition_grade_student').val()
        },
        success: function(response) {
            console.log(response);
            if (response == "success") {
                Swal.fire({
                    title: 'อนุมัติสำเร็จ',
                    icon: 'success',
                    confirmButtonColor: '#27AE60',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    header_back();
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            } else if (response == "fail") {
                Swal.fire({
                    title: 'ไม่สามารถอนุมัติได้',
                    icon: 'error',
                    confirmButtonColor: '#FF2557',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            }
        }
    })
}

function disapproved_petition_grade() {
    $.ajax({
        url: "manage_grade.php?method=disapproved_grade",
        type: "post",
        data: {
            grade_id: $('#input_petition_grade_student').val()
        },
        success: function(response) {
            // console.log(response);
            if (response == "success") {
                Swal.fire({
                    title: 'ตรวจคำร้องสำเร็จ',
                    icon: 'success',
                    confirmButtonColor: '#27AE60',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    header_back();
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            } else if (response == "fail") {
                Swal.fire({
                    title: 'ไม่สามารถทำรายการได้',
                    icon: 'error',
                    confirmButtonColor: '#FF2557',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    $('.tab-pane.active').find('#table').bootstrapTable('refresh');
                })
            }
        }
    })
}