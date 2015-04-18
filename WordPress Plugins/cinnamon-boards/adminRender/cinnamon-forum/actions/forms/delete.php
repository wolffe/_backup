<?php  
$idToDelete = $_GET['id'];

if(!empty($_POST) && isset($_POST['action'])) {
    if($_POST['action'] == 1) {
        $delete = new forum;
        $delete->deleteForumAdmin($idToDelete);
        $urlAfterDelete = $_GET['page'];
        echo '<script>window.location="?page=' . $urlAfterDelete . '&delete=0"</script>';
    }
}
?>

<h1>Are you sure you want to delete this?</h1>
<form method="post">
    <input type="hidden" name="action" value="1">
    <input type="hidden" name="urlAfterDelete" value="<?php echo $urlAfterDelete; ?>">
    <input type="submit" class="button-primary" value="Permanently Delete">
</form>
