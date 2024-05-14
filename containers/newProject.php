<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/css/multi-select-tag.css">
  <link rel="stylesheet" href="styles/textArea.css">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <div class="body p-3">
    <section class="pageTitle1 p-3">
      <h2>New Project</h2>
    </section>
    <div class="separator"></div>

    <div class="container p-3">
      <div class="top-border-box">

        <form class="row g-3">
          <div class="col-md-6">
            <label for="validationDefault01" class="form-label">Project Name</label>
            <input name="project_name" type="text" class="form-control" id="validationDefault01" required>
          </div>

          <div class="col-md-6">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" value="Select Status" required>
              <option value="" disabled selected>Select Status</option>
              <option value="Active">Active</option>
              <option value="Completed">Completed</option>
              <option value="On-hold">On-hold</option>
            </select>
          </div>

          <div class="col-md-6">
            <label for="validationDefault02" class="form-label">Start Date</label>
            <input name="startdate" type="date" class="form-control" id="validationDefault02" required>
          </div>
          <div class="col-md-6">
            <label for="validationDefault03" class="form-label">End Date</label>
            <input name="enddate" type="date" class="form-control" id="validationDefault03" required>
          </div>
          <div class="col-md-6">
            <label for="projectmanager" class="form-label">Project Manager</label>
            <select class="form-select" id="projectmanager" name="projectmanager" value="Select Project Manager"
              required>
              <option value="" disabled selected>Select Project Manager</option>
              <option value="1">Manager 1</option>
              <option value="2">Manager 2</option>
              <option value="3">Manager 3</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="members" class="form-label">Members</label>
            <select class="form-select" name="members" id="members" multiple>
              <option value="1">Afghanistan</option>
              <option value="2">Australia</option>
              <option value="3">Germany</option>
              <option value="4">Canada</option>
              <option value="5">Russia</option>
            </select>
          </div>

          <div class="col-md-10">
            <label for="projectDescription" class="form-label">Project Description</label>
            <div class="btn-toolbar mb-2">
              <button class="btn btn-light" type="button" onclick="formatDoc('undo')"><i
                  class='bx bx-undo'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('redo')"><i
                  class='bx bx-redo'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('bold')"><i
                  class='bx bx-bold'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('underline')"><i
                  class='bx bx-underline'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('italic')"><i
                  class='bx bx-italic'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('strikeThrough')"><i
                  class='bx bx-strikethrough'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('justifyLeft')"><i
                  class='bx bx-align-left'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('justifyCenter')"><i
                  class='bx bx-align-middle'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('justifyRight')"><i
                  class='bx bx-align-right'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('justifyFull')"><i
                  class='bx bx-align-justify'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('insertOrderedList')"><i
                  class='bx bx-list-ol'></i></button>
              <button class="btn btn-light" type="button" onclick="formatDoc('insertUnorderedList')"><i
                  class='bx bx-list-ul'></i></button>
            </div>
            <div class="textArea form-control border p-3" id="content" contenteditable="true" spellcheck="false"
              style="min-height: 150px;">
              <p>Start writing here...</p>
            </div>
          </div>

          <div class="col-12 p-4">
            <button class="btn btn-primary" type="submit">Submit form</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/js/multi-select-tag.js"></script>
  <script>
    new MultiSelectTag('members', {
      rounded: true,
      shadow: true,
      tagColor: {
        textColor: '#327b2c',
        borderColor: '#004b55',
        bgColor: '#0000',
      },
      onChange: function (values) {
        console.log(values)
      }
    });
  </script>
  <script>
    function formatDoc(cmd, value = null) {
      if (value) {
        document.execCommand(cmd, false, value);
      } else {
        document.execCommand(cmd);
      }
    }

    var content = document.getElementById('content');

    content.addEventListener('focus', function () {
      if (content.innerText.trim() === 'Start writing here...') {
        content.innerText = '';
      }
    });

    content.addEventListener('blur', function () {
      if (content.innerText.trim() === '') {
        content.innerHTML = '<p>Start writing here...</p>';
      }
    });

    content.addEventListener('mouseenter', function () {
      const a = content.querySelectorAll('a');
      a.forEach(item => {
        item.addEventListener('mouseenter', function () {
          content.setAttribute('contenteditable', false);
          item.target = '_blank';
        })
        item.addEventListener('mouseleave', function () {
          content.setAttribute('contenteditable', true);
        })
      })
    });

    content.addEventListener('keydown', function (event) {
      if (event.key === 'Backspace' && (this.textContent.trim() === '')) {
        event.preventDefault();
      }
    });
  </script>
</body>

</html>