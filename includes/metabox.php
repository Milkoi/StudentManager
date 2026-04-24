<?php

// ==========================
// 1. THÊM META BOX
// ==========================
function sm_add_meta_box() {
    add_meta_box(
        'sm_student_info',            // ID
        'Thông tin sinh viên',        // Title
        'sm_meta_box_callback',       // Callback hiển thị
        'sinh_vien',                  // Post type
        'normal',                     // Vị trí
        'high'                        // Ưu tiên
    );
}
add_action('add_meta_boxes', 'sm_add_meta_box');


// ==========================
// 2. HIỂN THỊ FORM
// ==========================
function sm_meta_box_callback($post) {

    // Tạo nonce bảo mật
    wp_nonce_field('sm_save_data', 'sm_nonce');

    // Lấy dữ liệu cũ (nếu có)
    $mssv = get_post_meta($post->ID, '_mssv', true);
    $lop = get_post_meta($post->ID, '_lop', true);
    $ngaysinh = get_post_meta($post->ID, '_ngaysinh', true);
?>

    <p><strong>Mã số sinh viên (MSSV):</strong></p>
    <input 
        type="text" 
        name="mssv" 
        value="<?php echo esc_attr($mssv); ?>" 
        style="width:100%;" 
    />

    <p><strong>Lớp / Chuyên ngành:</strong></p>
    <select name="lop">
        <option value="">-- Chọn lớp --</option>
        <option value="CNTT" <?php selected($lop, 'CNTT'); ?>>CNTT</option>
        <option value="Kinh tế" <?php selected($lop, 'Kinh tế'); ?>>Kinh tế</option>
        <option value="Marketing" <?php selected($lop, 'Marketing'); ?>>Marketing</option>
    </select>

    <p><strong>Ngày sinh:</strong></p>
    <input 
        type="date" 
        name="ngaysinh" 
        value="<?php echo esc_attr($ngaysinh); ?>" 
    />

<?php
}


// ==========================
// 3. LƯU DỮ LIỆU
// ==========================
function sm_save_meta_box($post_id) {

    // ✔ Chỉ áp dụng cho post type sinh_vien
    if (get_post_type($post_id) != 'sinh_vien') {
        return;
    }

    // ✔ Kiểm tra nonce
    if (!isset($_POST['sm_nonce']) || !wp_verify_nonce($_POST['sm_nonce'], 'sm_save_data')) {
        return;
    }

    // ✔ Tránh autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // ✔ Kiểm tra quyền
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // ✔ Kiểm tra dữ liệu tồn tại
    if (!isset($_POST['mssv']) || !isset($_POST['lop']) || !isset($_POST['ngaysinh'])) {
        return;
    }

    // ✔ Sanitize dữ liệu
    $mssv = sanitize_text_field($_POST['mssv']);
    $lop = sanitize_text_field($_POST['lop']);
    $ngaysinh = sanitize_text_field($_POST['ngaysinh']);

    // ✔ Lưu vào database
    update_post_meta($post_id, '_mssv', $mssv);
    update_post_meta($post_id, '_lop', $lop);
    update_post_meta($post_id, '_ngaysinh', $ngaysinh);
}
add_action('save_post', 'sm_save_meta_box');