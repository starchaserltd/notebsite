var notificationTypes=
{
	info: { iconClass: 'fa-info-circle' },
	warning: { iconClass: 'fa-exclamation-triangle' }
}
var notificationsListContainer;
var notificationsModalMessage = document.querySelector('#notificationsModal .notification-message');

function createModelNotificationMarkup(notificationType, message, componentsList) {
    var modalMarkup = `
        <div class="modal-body">
            <div class="notification-message"></div>
            <div class="list-container"></div>
            <button type="button" class="btn btn-outline-primary btn-md" data-dismiss="modal" aria-label="Close">OK</button>
        </div>
    `;
    var notificationMessageContent = `
        <div class='notification-icon fa ${notificationTypes[notificationType].iconClass}'></div>
        <div class='notification-message-text'>${message}</div>
    `;
    $('#notificationsModal .modal-content').html(modalMarkup);
    $('#notificationsModal .notification-message').html(notificationMessageContent);
    
	if (componentsList)
	{
        notificationsListContainer = document.querySelector('#notificationsModal .list-container');
        var firstListElem = notificationsListContainer.appendChild(document.createElement('ul'));
		if (componentsList.length > 4)
		{
			var firstList = componentsList.splice(0,Math.round(componentsList.length/2));
			firstListElem.classList.add('first');
			var secondListElem = firstListElem.insertAdjacentElement('afterend', document.createElement('ul'));
			secondListElem.classList.add('second');

			var componentsFirstListElement = document.querySelector('#notificationsModal .modal-body ul.first');
			var componentsSecondListElement = document.querySelector('#notificationsModal .modal-body ul.second');
			for (component of firstList) { componentsFirstListElement.appendChild(document.createElement('li')).innerHTML = component; }
			for (component of componentsList) { componentsSecondListElement.appendChild(document.createElement('li')).innerHTML = component; }
		}
		else
		{
			notificationsListContainer.appendChild(document.createElement('ul'));
			var componentsListElement = document.querySelector('#notificationsModal .modal-body ul');
			for (component of componentsList)
			{ componentsListElement.appendChild(document.createElement('li')).innerHTML = component; }
		}
	}
}

function createModelGalleryMarkup(event) {
    var modalMarkup = `
        <div class="modal-header">
            <button type="button" class="close fa fa-times" data-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <div class="modal-body">
            <i class="fas fa-chevron-left imgControl prevImage"></i>
            <i class="fas fa-chevron-right imgControl nextImage"></i>
        </div>
    `;
    $('#notificationsModal').addClass('galleryModal');

    $('#notificationsModal .modal-content').html(modalMarkup);

    var button = $(event) // Button that triggered the modal
    var recipient = button.data('dot') // Extract info from data-* attributes
    var modal = $('#notificationsModal');
    modal.find('.modal-body').append(recipient);
}

function showNotification(notificationType, message, componentsList, event)
{
	switch (notificationType) {
		case 'info': {
			createModelNotificationMarkup(notificationType, message, componentsList);
        }
        break;
		case 'warning': {
			createModelNotificationMarkup(notificationType, message);
        }
        break;
        case 'model-gallery': {
            createModelGalleryMarkup(event);
        }
        break;
		default:
			break;
	}
	$('#notificationsModal').modal('toggle');
}

function closeNotificationModal()
{
    $('#notificationsModal').removeClass('galleryModal');
    $('#notificationsModal .modal-content').empty()
}
$('#notificationsModal').on('hidden.bs.modal', function (e){ closeNotificationModal(); });