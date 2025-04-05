// Main JavaScript file for Galerie Oselo

document.addEventListener('DOMContentLoaded', function() {
  // Success message handling
  const urlParams = new URLSearchParams(window.location.search);
  const success = urlParams.get('success');
  const error = urlParams.get('error');
  
  if (success) {
      let message = '';
      
      // Determine le message de succès
      switch(success) {
          case '1':
              message = 'Record created successfully.';
              break;
          case '2':
              message = 'Record updated successfully.';
              break;
          case '3':
              message = 'Record deleted successfully.';
              break;
          default:
              message = 'Operation completed successfully.';
      }
      
      
      showAlert(message, 'success');
  }
  
  if (error) {
      let message = '';
      
      // Determine error message based on error code
      switch(error) {
          case '1':
              message = 'An error occurred during the operation.';
              break;
          default:
              message = 'An error occurred.';
      }
      
      // Create and display error message
      showAlert(message, 'danger');
  }
  
  // Handle responsive tables
  makeTablesResponsive();
});

// Function pour l'alerte message 
function showAlert(message, type) {
  const container = document.querySelector('.container');
  
  if (container) {
      const alert = document.createElement('div');
      alert.className = `alert alert-${type} alert-dismissible fade in`;
      alert.role = 'alert';
      
      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'close';
      button.setAttribute('data-dismiss', 'alert');
      button.setAttribute('aria-label', 'Close');
      
      const span = document.createElement('span');
      span.setAttribute('aria-hidden', 'true');
      span.innerHTML = '&times;';
      
      button.appendChild(span);
      alert.appendChild(button);
      alert.appendChild(document.createTextNode(message));
      
      // Inserrer l'alerte apres le header
      const header = container.querySelector('.page-header');
      if (header) {
          // @ts-ignore
          header.parentNode.insertBefore(alert, header.nextSibling);
      } else {
          container.insertBefore(alert, container.firstChild);
      }
      
      // Automatically dismiss the alert after 5 seconds 
      setTimeout(function() {
          alert.style.opacity = '0';
          setTimeout(function() {
              // @ts-ignore
              alert.parentNode.removeChild(alert);
          }, 500);
      }, 5000);
  }
}

// Responsivité des tables
function makeTablesResponsive() {
  const tables = document.querySelectorAll('table');
  
  tables.forEach(function(table) {
      // @ts-ignore
      if (!table.parentElement.classList.contains('table-responsive')) {
          const wrapper = document.createElement('div');
          wrapper.className = 'table-responsive';
          // @ts-ignore
          table.parentNode.insertBefore(wrapper, table);
          wrapper.appendChild(table);
      }
  });
}