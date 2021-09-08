<div class="modal fade" id="roleModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="role-form" method="post">
                <div class="modal-header">
                    <h3 class="modal-title" id="titleModal">หน้าที่สามารถเข้าถึงได้</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="role_id" name="role_id">
                    <!-- <input class="form-check-input" type="checkbox" value="list_role" name="check_permission" disabled>&nbsp;&nbsp;จัดการสิทธิ์ <span style="color: red;">(หน้านี้ใช้ได้เฉพาะ ADMIN)</span>
                    <br> -->
                    <input class="form-check-input" type="checkbox" value="list_teacher" name="check_permission">&nbsp;&nbsp;รายชื่อผู้สอน
                    <br>
                    <input class="form-check-input" type="checkbox" value="list_student" name="check_permission">&nbsp;&nbsp;รายชื่อนักเรียน
                    <br>
                    <input class="form-check-input" type="checkbox" value="list_parent" name="check_permission">&nbsp;&nbsp;รายชื่อผู้ปกครอง
                    <br>
                    <input class="form-check-input" type="checkbox" value="status_teacher" name="check_permission">&nbsp;&nbsp;การใช้งานของผู้สอน
                    <br>
                    <input class="form-check-input" type="checkbox" value="status_student" name="check_permission">&nbsp;&nbsp;การใช้งานของนักเรียน
                    <br>
                    <input class="form-check-input" type="checkbox" value="status_parent" name="check_permission">&nbsp;&nbsp;การใช้งานของผู้ปกครอง
                    <br>
                    <input class="form-check-input" type="checkbox" value="course" name="check_permission">&nbsp;&nbsp;จัดการรายวิชา
                    <br>
                    <input class="form-check-input" type="checkbox" value="teacher_course" name="check_permission">&nbsp;&nbsp;รายวิชาที่สอน
                    <br>
                    <input class="form-check-input" type="checkbox" value="student_course" name="check_permission">&nbsp;&nbsp;รายวิชาที่เรียน
                    <br>
                    <input class="form-check-input" type="checkbox" value="grade" name="check_permission">&nbsp;&nbsp;ผลการเรียน
                    <br>
                    <input class="form-check-input" type="checkbox" value="petition_grade" name="check_permission">&nbsp;&nbsp;คำร้องขอตัดเกรด
                    <br>
                    <input class="form-check-input" type="checkbox" value="petition_course" name="check_permission">&nbsp;&nbsp;คำร้องขอเพิ่ม / ถอนรายวิชา
                    <br>
                    <input class="form-check-input" type="checkbox" value="petition" name="check_permission">&nbsp;&nbsp;จัดการคำร้องอื่น ๆ
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>