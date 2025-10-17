<?php
if (isset($_FILES['upload']['name'])) {
    $file = $_FILES['upload']['tmp_name'];
    $file_name = $_FILES['upload']['name'];
    $file_name_array = explode(".", $file_name);
    $extension = end($file_name_array);
    $new_image_name = rand() . '.' . $extension;

    $allowed_extension = array("jpg", "jpeg", "gif", "png");

    if (in_array($extension, $allowed_extension)) {
        $path = "../userfiles/" . $new_image_name;
        move_uploaded_file($file, $path);
        $function_number = $_GET['CKEditorFuncNum'];
        if (file_exists($file)) {
            unlink($file);
        }
        $message = '';
        echo "<script type='text/javascript'>
                window.parent.CKEDITOR.tools.callFunction($function_number,'$path','$message');
             </script>";
    } else if ($extension === "mp3") {
        $path = "../files/sound/" . $file_name;
        move_uploaded_file($file, $path);
        $function_number = $_GET['CKEditorFuncNum'];
        if (file_exists($file)) {
            unlink($file);
        }
        $message = '';
        echo "<script type='text/javascript'>
                window.parent.CKEDITOR.tools.callFunction($function_number,'$path','$message');
             </script>";
    } else if ($extension === "mp4" || $extension === "MP4" || $extension === "mov") {
        // echo "<script type='text/javascript'>
        //         alert('is working...');
        //      </script>";
        $path = "../video/" . $file_name;
        move_uploaded_file($file, $path);
        $function_number = $_GET['CKEditorFuncNum'];
        if (file_exists($file)) {
            unlink($file);
        }
        $message = '';
        echo "<script type='text/javascript'>
                window.parent.CKEDITOR.tools.callFunction($function_number,'$path','$message');
             </script>";
    }
}else{
    echo "<script type='text/javascript'>
            alert('Sorry, something went wrong...');
          </script>";
}
?>