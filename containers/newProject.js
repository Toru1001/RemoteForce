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

