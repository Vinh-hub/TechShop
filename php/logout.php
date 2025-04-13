<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hủy tất cả dữ liệu session
    session_unset();
    session_destroy();
    
    // Trả về phản hồi JSON
    echo json_encode(['success' => true]);
    exit();
}

echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ.']);
exit();
?>