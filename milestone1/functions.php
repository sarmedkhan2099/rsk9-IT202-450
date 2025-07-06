<?php
function has_role($role) {
    return in_array($role, $_SESSION['roles'] ?? []);
}
?>
