const account_manage = document.getElementById("account_manage");
const nav_drawer = document.getElementById("nav-drawer");
const drawer_action = document.getElementById("open-drawer");

drawer_action.addEventListener('click', function() {
    if (nav_drawer.open) {
        nav_drawer.open = false;
    }
    else {
        nav_drawer.open = true;
    }
})

account_manage.addEventListener('click', function() {
    window.location.href = "/account/manage.php";
})