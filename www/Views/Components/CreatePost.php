<script>
  tinymce.init({
    selector: 'textarea',
    skin: (window.matchMedia("(prefers-color-scheme: dark)").matches ? "oxide-dark" : ""),
    content_css: (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : ""),
    plugins: [
      'anchor', "code revisionhistory", 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown',
    ],
    toolbar: 'undo redo revisionhistory | code | undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
</script>



<script>
  document.addEventListener('DOMContentLoaded', function() {
      const postTypeSelect = document.querySelector('select[name="post-type"]');
      const eventFields = document.querySelectorAll('.event-field');

      function toggleEventFields() {
          const isEvent = postTypeSelect.value === 'Évènement';
          eventFields.forEach(field => {
              field.style.display = isEvent ? 'block' : 'none';
              field.required = isEvent;
          });
      }

      postTypeSelect.addEventListener('change', toggleEventFields);
      toggleEventFields(); 
  });
</script>