function main() {
  $(document).ready(function () {
    $("#btn-upload").click(function () {
      $("#btn-upload-video").click();
    });
    $("#btn-upload-video").change(function () {
      let videoFile = $(this)[0].files[0];

      if (videoFile) {
        let formData = new FormData();
        formData.append("video", videoFile);
        $.ajax({
          url: "uploadVideoFunction.php", // File PHP xử lý cập nhật
          type: "POST",
          data: formData,
          contentType: false,
          processData: false, // Không xử lý data thành chuỗi query string application/json
          success: function (response) {
            // Thành công, có thể chuyển hướng
            window.location.href = "/streamable/dashboard.php"; // Chuyển đến trang sau khi upload thành công
            // 777 để nhận biết được param và tải nó ra.
          },
          error: function (xhr, status, error) {
            console.log("Có lỗi xảy ra:", error);
          },
        });
      } else {
        console.log("Chưa chọn video.");
      }
    });
  });
}

main();
