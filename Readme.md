- Khi upload chuyển sang trang home trước
- ở home ta gửi ajax hiên thị ra danh sách các video đã upload từ trước
- và hiển thị một ô video trông đang loading để khi loadding xong thì bắt đầu gọi lại ajax và hiển thị ra danh sach video lần nữa.
- Còn phân quyền hay user thì mình sẽ viết sau khi làm xong chức năng.

## Từng bước chức năng:

- Kiểm tra lỗi ajax: do trình duyệt đổi qua chrome nha.
- hiển thị ra danh sách tải lên db:
- tạo ra page đơn giản để test chức năng thôi
- tạo ra trang edit video và làm chức năng edit video đó.
  đã xong
- tạo edit gồm đổi tên tag, categories and title video là được đã xong và chỉnh lại db một chút đã xong.
- Thêm nhìu video và nhận api từ người khác gửi tới ta tạo thêm key để nhận nha.
- Các vấn đề:
  1.trong khi upload nãy thì phải chuyển qua trang khác liền .

  2. nên đưa video mới upload lên đầu trang để người dùng nhận biết.

  -Lưu ý:

* Mỗi câu lệnh mysql chỉ nên close một lần thôi nha.

* nếu một video có nhiều tag thì hiển thị các tag đâý ra và lấy id tag nào thì sửa tag đó là xong.

* Hồi cần xem lại logic của chức năng edit nha và xác định cả id và name luôn để không tạo qua nhiều
  bảng ghi trùng tên categories trong db bảng ctg và tagname nên không cần xoá đồng bộ cũng được.
