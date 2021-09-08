<div class="modal fade" id="listModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="list-form" method="post">
                <div class="modal-header">
                    <h3 class="modal-title" id="titleModal">แก้ไข</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </symbol>
                    </svg>
                    <div class="alert alert-danger align-items-center justify-content-center mb-1" role="alert" style="display: none;">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                            <use xlink:href="#exclamation-triangle-fill" />
                        </svg>
                        <div class="error"></div>
                    </div>
                    <input type="hidden" id="list_id" name="list_id">
                    <label for="UserID" id="txtuserid">รหัสประจำตัว :</label><br>
                    <input type="text" id="list_userid" name="list_userid" class="form-control" value=""><br>
                    <label for="Name">ชื่อ - นามสกุล :</label><br>
                    <input type="text" id="list_name" name="list_name" class="form-control" value=""><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>