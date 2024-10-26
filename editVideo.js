$(document).ready(function () {
  // Function to load video list using AJAX
  // Lấy URL hiện tại
  const urlParams = new URLSearchParams(window.location.search);

  // Lấy giá trị của tham số 'id'
  const id = urlParams.get("id");

  function loadVideo() {
    $.ajax({
      url: "getVideo.php", // The PHP file to fetch data from the database
      type: "GET",
      data: { id },
      dataType: "json",
      success: function (response) {
        if (response.status === 200) {
          let videoEdit = $("#video");
          videoEdit.empty(); // Clear the previous content
          console.log(response);
          // Loop through the videos and generate HTML
          $.each(response.video, function (index, video) {
            videoEdit.append(`
                           <div class="col-md-4 mx-auto">
                                <div class="card mb-4">
                                    <img src="uploads/thumbnails/${
                                      video.thumbnail
                                    }" class="card-img-top" alt="Thumbnail">
                                    <div class="card-body">
                                         <div>
                                            <label for="edit-title" class="form-label col-md-2">Title</label>
                                            <div class="col-md-10">
                                             <input type="text" class="form-control" id="edit-title" value="${
                                               video.title
                                             }" placeholder="Change Title">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="edit-category" class="form-label">Categories</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control mb-2" id="edit-category" value="${
                                                  video.category
                                                    ? video.category
                                                    : "undefined"
                                                }" placeholder="Change Category">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="edit-tag" class="form-label col-md-2">Tag Name</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control mb-2" id="edit-tag" value="${
                                                  video.tag_name
                                                }" placeholder="Change Tag">
                                            </div>
                                        </div>
                                        <button class="btn btn-success save-changes-btn" 
                                        }">Save Changes</button>
                                    </div>
                                </div>
                            </div>

                        `);
          });

          // Event handlers for edit buttons
          $(".save-changes-btn").click(function () {
            let title = $("#edit-title").val();
            let category = $("#edit-category").val();
            let tagName = $("#edit-tag").val();
            let data = {
              id,
              title,
              category,
              tagName,
            };
            $.ajax({
              url: "editVideoFunction.php",
              type: "POST",
              data: data,
              dataType: "json",
              success: function (response) {
                alert(response.message);
                loadVideo(); // Reload the video list after deletion
              },
              error: function (error) {
                console.log(error, message);
              },
            });
          });
        }
      },
    });
  }

  // Initial load of the videos
  loadVideo();
});
