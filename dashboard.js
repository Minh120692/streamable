$(document).ready(function () {
  // Function to load video list using AJAX
  function loadVideos() {
    $.ajax({
      url: "getVideos.php", // The PHP file to fetch data from the database
      type: "GET",
      dataType: "json",
      success: function (response) {
        if (response.status === 200) {
          let videoList = $("#video-list");
          videoList.empty(); // Clear the previous content
          console.log(response);
          // Loop through the videos and generate HTML
          $.each(response.videos, function (index, video) {
            videoList.append(`
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img src="uploads/thumbnails/${video.thumbnail}" class="card-img-top" alt="Thumbnail">
                                <div class="card-body">
                                    <h5 class="card-title">${video.title}</h5>
                                    <a href="uploads/videos/${video.file_path}" class="btn btn-primary" target="_blank">Watch</a>
                                    <button class="btn btn-warning edit-btn" data-id="${video.id}">Edit</button>
                                    <button class="btn btn-danger delete-btn" data-id="${video.id}">Delete</button>
                                </div>
                            </div>
                        </div>
                    `);
          });

          // Event handlers for edit and delete buttons
          $(".edit-btn").click(function () {
            let videoId = $(this).data("id");
            window.location.href = `/streamable/editVideo.php?id=${videoId}`;
            // lam trang edit va cac chuc nang nua la xong
          });

          $(".delete-btn").click(function () {
            let videoId = $(this).data("id");

            if (confirm("Are you sure you want to delete this video?")) {
              $.ajax({
                url: "deleteVideo.php",
                type: "POST",
                data: {
                  id: videoId,
                },
                success: function (response) {
                  alert(response.message);
                  loadVideos(); // Reload the video list after deletion
                },
              });
            }
          });
        }
      },
    });
  }

  // Initial load of the videos
  loadVideos();
});
