document.addEventListener("DOMContentLoaded", () => {
    const notificationIcon = document.getElementById("notification-icon");
    const notificationDropdown = document.getElementById("notification-dropdown");

    if (!notificationIcon || !notificationDropdown) {
        console.error("Các phần tử không tồn tại trong DOM.");
        return;
    }

    notificationIcon.addEventListener('click', function () {
        notificationDropdown.style.display =
            notificationDropdown.style.display === 'none' || notificationDropdown.style.display === '' 
                ? 'block' 
                : 'none';
    });

    document.addEventListener("click", (e) => {
        if (!notificationDropdown.contains(e.target) && !notificationIcon.contains(e.target)) {
            notificationDropdown.style.display = "none";
        }
    });
    window.removeNotification = function (button) {
        const notificationItem = button.closest(".notification-item"); 
        if (notificationItem) {
            notificationItem.remove(); 
        }
    };
    
});

