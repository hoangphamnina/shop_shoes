<?php
if ($act == "add") $labelAct = "Thêm mới";
else if ($act == "edit") $labelAct = "Chỉnh sửa";

$linkMan = "index.php?com=product&act=man";
if ($act == 'add') $linkFilter = "index.php?com=product&act=add";
else if ($act == 'edit') $linkFilter = "index.php?com=product&act=edit&id=" . $id;
$linkSave = "index.php?com=product&act=save";
?>

<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?> sản phẩm</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form class="validation-form" novalidate method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here" disabled><i class="far fa-save mr-2"></i>Lưu tại trang</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="row">
            <div class="col-xl-8"">
                <?php
                $slugchange = ($act == 'edit') ? 1 : 0;
                include TEMPLATE . LAYOUT . "slug.php";
                ?>
                <div class=" card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Nội dung sản phẩm</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tiêu đề:</label>
                        <input type="text" class="form-control for-seo text-sm" name="data[name]" id="name" placeholder="Tiêu đề" value="<?= (!empty($flash->has('name'))) ? $flash->get('name') : @$item['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả:</label>
                        <textarea class="form-control for-seo text-sm <?= (isset($config['product']['desc_cke']) && $config['product']['desc_cke'] == true) ? 'form-control-ckeditor' : '' ?>" name="data[desc]" id="desc" rows="5" placeholder="Mô tả"><?= $func->decodeHtmlChars($flash->get('desc')) ?: $func->decodeHtmlChars(@$item['desc']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung:</label>
                        <textarea class="form-control for-seo text-sm <?= (isset($config['product']['content_cke']) && $config['product']['content_cke'] == true) ? 'form-control-ckeditor' : '' ?>" name="data[content]" id="content" rows="5" placeholder="Nội dung"><?= $func->decodeHtmlChars($flash->get('content')) ?: $func->decodeHtmlChars(@$item['content']) ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Danh mục sản phẩm</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group-category row">
                        <div class="col-xl-6 col-sm-4">
                            <label class="d-block" for="id_list">Loại sản phẩm:</label>
                            <?= $func->getAjaxCategory('product', 'list', 'Chọn loại') ?>
                        </div>
                        <div class="col-xl-6 col-sm-4">
                            <label class="d-block" for="id_brand">Danh mục hãng:</label>
                            <?= $func->getAjaxCategory('product', 'brand', 'Chọn hãng') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Hình ảnh sản phẩm</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    /* Photo detail */
                    $photoDetail = array();
                    $photoDetail['upload'] = UPLOAD_PRODUCT_L;
                    $photoDetail['image'] = (!empty($item)) ? $item['photo'] : '';
                    $photoDetail['dimension'] = "Width: " . $config['product']['width'] . " px - Height: " . $config['product']['height'] . " px (.jpg|.gif|.png|.jpeg|.gif)";
                    /* Image */
                    include TEMPLATE . LAYOUT . "image.php";
                    ?>
                </div>
            </div>
        </div>
        </div>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin sản phẩm</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="numb" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                    <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="data[numb]" id="numb" placeholder="Số thứ tự" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="d-block" for="code">Mã sản phẩm:</label>
                        <input type="text" class="form-control text-sm" name="data[code]" id="code" placeholder="Mã sản phẩm" value="<?= (!empty($flash->has('code'))) ? $flash->get('code') : @$item['code'] ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="d-block" for="regular_price">Giá bán:</label>
                        <div class="input-group">
                            <input type="text" class="form-control format-price regular_price text-sm" name="data[regular_price]" id="regular_price" placeholder="Giá bán" value="<?= (!empty($flash->has('regular_price'))) ? $flash->get('regular_price') : @$item['regular_price'] ?>">
                            <div class="input-group-append">
                                <div class="input-group-text"><strong>VNĐ</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="d-block" for="sale_price">Giá mới:</label>
                        <div class="input-group">
                            <input type="text" class="form-control format-price sale_price text-sm" name="data[sale_price]" id="sale_price" placeholder="Giá mới" value="<?= (!empty($flash->has('sale_price'))) ? $flash->get('sale_price') : @$item['sale_price'] ?>">
                            <div class="input-group-append">
                                <div class="input-group-text"><strong>VNĐ</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>