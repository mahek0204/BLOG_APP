@extends('layout.header')

<div class="layout-page">
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      
      <!-- Offcanvas for Adding New Record -->
      <div class="card">
        <div class="offcanvas offcanvas-end" id="add-new-record">
          <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">New Record</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>

          <div class="offcanvas-body flex-grow-1">
            <form class="add-new-record pt-0 row g-2" id="postForm" action="" enctype="multipart/form-data">

              <div class="col-sm-12 form-control-validation">
                <label class="form-label">Title</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text"><i class="icon-base ti tabler-user"></i></span>
                   <input type="text" id="title" placeholder="Title" class="form-control dt-full-name" aria-label="John Doe" required />
                </div>
              </div>

              <div class="col-sm-12 form-control-validation">
                <label class="form-label">Content</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text"><i class="icon-base ti tabler-user"></i></span>
                  <textarea id="content" placeholder="Content" class="form-control dt-full-name" aria-label="John Doe" required></textarea>
                </div>
              </div>

              <div class="col-sm-12 form-control-validation">
                <label class="form-label">Post</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text"><i class="icon-base ti tabler-user"></i></span>
                  <input type="file" class="form-control dt-source"id="image" name="image" placeholder="Referral" aria-label="Referral" />
                </div>
              </div>

              <div class="col-sm-12 form-control-validation">
                <label class="form-label">Published at</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text"><i class="icon-base ti tabler-user"></i></span>
                  <input type="datetime-local" class="form-control dt-number" id="published_at" ria-label="1234567890" />
                </div>
              </div> 

              <div class="col-sm-12">
                <button type="submit" class="btn btn-primary data-submit me-sm-4 me-1">Submit</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
              </div>
            </form>
            <div id="resultMsg"></div>
          </div>
        </div>

        <!-- Table Section -->
        <div class="card-datatable text-nowrap">
          <div class="row card-header flex-column flex-md-row mx-0 px-3">
            <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
              <h5 class="card-title mb-0 text-md-start text-center pb-md-0 pb-6">MINI BLOG</h5>
            </div>  
            <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
              <div class="dt-buttons btn-group flex-wrap mb-0">
                <div class="btn-group">
                  <button class="btn buttons-collection btn-label-primary dropdown-toggle me-4" type="button">
                    <span class="d-flex align-items-center gap-2">
                       <span class="d-none d-sm-inline-block">Export</span> 
                    </span>
                  </button>
                  <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="offcanvas" data-bs-target="#add-new-record">
                    <i class="icon-base ti tabler-plus icon-sm"></i>
                    <span class="d-none d-sm-inline-block">Add New Record</span>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <br>

          <div id="blog-list"></div>

          <style>
#blog-list {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* Exactly 3 columns */
    gap: 20px;
    margin-top: 20px;
}

.blog-card {
    border: 1px solid #ccc;
    padding: 15px;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
    background: #fff;
    border-radius: 8px;
}

.blog-card img {
    width: 100%;
    height: 150px;
    object-fit: contain;
    border-radius: 4px;
}
</style>

          
              @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              @endif

              <!-- Edit Modal -->
              <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 70%;">
                  <div class="modal-content">
                    <form id="editPostForm" enctype="multipart/form-data">
                      

                      <div class="modal-header">
                        <h5 class="modal-title">Update Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <div class="mb-12">
                          <label class="form-label">Title</label>
                            <input type="text" id="edit_title" class="form-control mb-2" required>                        
                        </div>

                        <div class="mb-12">
                          <label class="form-label">Content</label>
                          <textarea id="edit_content" class="form-control mb-2" required></textarea>
                        </div>

                        <div class="mb-12">
                          <label class="form-label">Published At</label>
                          <input type="datetime-local" id="edit_published_at" class="form-control mb-2" required>
                        </div>

                        <div class="mb-12">
                          <label class="form-label">Post</label>
                          <input type="file" id="edit_image" src="" alt="Old Image" class="form-control mb-2" required>  
                        </div>
                        </div>
                       
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              
          </table>
        </div>
      </div>

      <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1100">
    <div id="deleteToast" class="toast text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex align-items-center justify-content-between">
            <div class="toast-body d-flex align-items-center">
                
                Are you sure you want to delete this Post?
            </div>
            <div class="d-flex align-items-center ms-3">
                <button id="confirmDeleteToastBtn" class="btn btn-sm btn-light me-2">Yes</button>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>

      @if(isset($openModal) && $openModal)
      <script>
        window.onload = function () {
          var editModal = new bootstrap.Modal(document.getElementById('editModal'));
          editModal.show();
        };
      </script>
      @endif

        <script>
    document.addEventListener("DOMContentLoaded", function () {
    const deleteToastEl = document.getElementById('deleteToast');
    const deleteToast = new bootstrap.Toast(deleteToastEl);
    const confirmBtn = document.getElementById('confirmDeleteToastBtn');
    let pendingDeleteId = null;

    // Handle delete icon click
    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-delete]')) {
            e.preventDefault();
            const deleteBtn = e.target.closest('[data-delete]');
            pendingDeleteId = deleteBtn.getAttribute('data-id');
            deleteToast.show();
        }
    });

    // On "Yes" button click, send DELETE request
    confirmBtn.addEventListener("click", function () {
        if (pendingDeleteId) {
            $.ajax({
                url: `/api/posts/${pendingDeleteId}`,
                method: 'DELETE',
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('auth_token')
                },
                success: function () {
                    deleteToast.hide();
                    loadBlogs(); // Refresh the list
                },
                error: function () {
                    alert("Failed to delete post.");
                }
            });
        }
    });
});

      </script>

        

    </div>
  </div>
</div>

@extends('layout.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#postForm').submit(function(e) {
    e.preventDefault();

    let formData = new FormData();
    // formData.append('user_id',$('#user_id').val());
    formData.append('title', $('#title').val());
    formData.append('content', $('#content').val());
    formData.append('image', $('#image')[0].files[0]);
    formData.append('published_at', $('#published_at').val());

    $.ajax({
        url: '/api/posts',
        method: 'POST',
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('auth_token')
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function() {
            $('#resultMsg').html('<p style="color:green;">Post Created!</p>');
            $('#postForm')[0].reset();
            loadBlogs();
        },
        error: function() {
            $('#resultMsg').html('<p style="color:red;">Error creating post.</p>');
        }
    });
});

function loadBlogs() {
    $.ajax({
        url: '/api/posts',
        method: 'GET',
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('auth_token')
        },
        success: function(posts) {
            $('#blog-list').html('');
            posts.forEach(post => {
                $('#blog-list').append(`
                     <div class="blog-card">
                        <h4>${post.title}</h4>
                        <p>${post.content}</p>
                        ${post.image ? `<img src="/storage/${post.image}" alt="${post.title}"><br><br>` : ''}
                        <small>Published: ${post.published_at ?? 'N/A'}</small>
                    </div>
`               );
            });
        }
    });
}


function loadPostsByAuthor(authorId) {
    $.ajax({
        url: `/api/posts/author/${authorId}`,
        method: 'GET',
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('auth_token')
        },
        success: function(data) {
            $('#blog-list').html(`<h3>Posts by ${data.author}</h3>`);
            data.posts.forEach(post => {
                $('#blog-list').append(`
                    <div>
                        <h4>${post.title}</h4>
                        <p>${post.content}</p>
                    </div>
                `);
            });
        }
    });
}


function loadBlogs() {
    $.ajax({
        url: '/api/posts',
        method: 'GET',
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('auth_token')
        },
        success: function(posts) {
            $('#blog-list').html('');
            posts.forEach(post => {
                $('#blog-list').append(`
                    <div class="blog-card position-relative">
                        <div class="dropdown position-absolute top-0 end-0 m-2">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="icon-base ti tabler-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item edit-btn" href="" 
                                   data-id="${post.id}" 
                                   data-title="${post.title}" 
                                   data-content="${post.content}" 
                                   data-published="${post.published_at} ">
                                    <i class="icon-base ti tabler-pencil me-1"></i> Edit
                                </a>
                                <a class="dropdown-item" href="" data-delete data-id="${post.id}">
                                    <i class="icon-base ti tabler-trash me-1" ></i> Delete
                                </a>
                            </div>
                        </div>

                        <h4>${post.title}</h4>
                        <p>${post.content}</p>
                        ${post.image ? `<img src="/storage/${post.image}" alt="${post.title}"><br><br>` : ''}
                        <small>Published: ${post.published_at ?? 'N/A'}</small>
                    </div>
                `);
            });
        },
        error: function(err) {
            console.error("Error loading posts:", err);
            $('#blog-list').html('<p style="color:red;">Failed to load blog posts.</p>');
        }
    });
}
loadBlogs();

// Handle edit button click to open modal and populate fields
// $(document).on('click', '.edit-btn', function (e) {
//     e.preventDefault();
    
//     const id = $(this).data('id');
//     const title = $(this).data('title');
//     const content = $(this).data('content');
//     const publishedAt = $(this).data('published');

//     // Fill form fields
//     $('#edit_title').val(title);
//     $('#edit_content').val(content);
//     $('#edit_published_at').val(publishedAt);

//     // Save post ID for submission
//     $('#editPostForm').data('post-id', id);

//     // Show the modal
//     const editModal = new bootstrap.Modal(document.getElementById('editModal'));
//     editModal.show();
// });

$(document).on('click', '.edit-btn', function (e) {
    e.preventDefault();

    // Set form data
    const id = $(this).data('id');
    const title = $(this).data('title');
    const content = $(this).data('content');
    const publishedAt = $(this).data('published')?.trim();

    $('#edit_title').val(title);
    $('#edit_content').val(content);

    // Pre-fill published_at field (ensure it's in correct datetime-local format)
    if (publishedAt) {
        const formatted = new Date(publishedAt).toISOString().slice(0,16); // "YYYY-MM-DDTHH:MM"
        $('#edit_published_at').val(formatted);
    }

    // Optional: store post ID to submit later
    $('#editPostForm').data('post-id', id);

    // Show existing image (if needed)
    $.ajax({
        url: `/api/posts/${id}`,
        method: 'GET',
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('auth_token')
        },
        success: function (post) {
            if (post.image) {
                $('#edit_image').after(`
                    <img id="previewImage" src="/storage/${post.image}" 
                         alt="Post Image" style="margin-top:10px; max-height:100px;" />
                `);
            }
        }
    });

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
});


$('#editPostForm').submit(function(e) {
    e.preventDefault();

    const postId = $(this).data('post-id');
    let formData = new FormData();
    formData.append('title', $('#edit_title').val());
    formData.append('content', $('#edit_content').val());
    formData.append('published_at', $('#edit_published_at').val());
    if ($('#edit_image')[0].files[0]) {
        formData.append('image', $('#edit_image')[0].files[0]);
    }

    $.ajax({
        url: `/api/posts/${postId}`,
        method: 'POST', // Laravel PUT via POST
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
            'X-HTTP-Method-Override': 'PUT'
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            $('#editPostForm')[0].reset();
            $('.modal').modal('hide');
            loadBlogs();
        },
        error: function () {
            alert("Can not update this post.");
        }
    });
});





</script>
