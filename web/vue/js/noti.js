document.addEventListener("DOMContentLoaded", () => {
    const notificationIcon = document.getElementById("notification-icon");
    const notificationDropdown = document.getElementById("notification-dropdown");

    // Toggle dropdown khi nhấn vào biểu tượng thông báo
    notificationIcon.addEventListener('click', function () {
        notificationDropdown.style.display =
            notificationDropdown.style.display === 'none' || notificationDropdown.style.display === '' 
                ? 'block' 
                : 'none';
    });

    // Ẩn dropdown khi click ra ngoài
    document.addEventListener("click", (e) => {
        if (!notificationDropdown.contains(e.target) && !notificationIcon.contains(e.target)) {
            notificationDropdown.style.display = "none";
        }
    });
});
