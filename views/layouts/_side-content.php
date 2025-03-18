  <?php

    use app\modules\base\Config;

    $getThemeUrl = fn ($name) => $bundle->url("sass/dashmix/themes/$name.scss");
    $capHanhchinh = Config::getCapHanhchinh();
    ?>
  <div class="content-side">
      <!-- Side Overlay Tabs -->
      <div class="block block-transparent pull-x pull-t">

          <div class="block-content tab-content overflow-hidden pt-0">
              <!-- Settings Tab -->
              <div class="tab-pane pull-x fade fade-up show active" id="so-settings" role="tabpanel" aria-labelledby="so-settings-tab" tabindex="0">
                  <div class="block mb-0">
                      <!-- Color Themes -->
                      <!-- Toggle Themes functionality initialized in Template._uiHandleTheme() -->
                      <div class="block-content block-content-sm block-content-full bg-body">
                          <span class="text-uppercase fs-sm fw-bold">Color Themes</span>
                      </div>
                      <div class="block-content block-content-full">
                          <div class="row g-sm text-center">
                              <div class="col-4 mb-1">
                                  <a class="d-block py-3 text-white fs-sm fw-semibold bg-default" data-toggle="theme" data-theme="default" href="#">
                                      Default
                                  </a>
                              </div>
                              <div class="col-4 mb-1">
                                  <a class="d-block py-3 text-white fs-sm fw-semibold bg-xwork" data-toggle="theme" data-theme="<?= $getThemeUrl('xwork') ?>" href="#">
                                      xWork
                                  </a>
                              </div>
                              <div class="col-4 mb-1">
                                  <a class="d-block py-3 text-white fs-sm fw-semibold bg-xmodern" data-toggle="theme" data-theme="<?= $getThemeUrl('xmodern') ?>" href="#">
                                      xModern
                                  </a>
                              </div>
                              <div class="col-4 mb-1">
                                  <a class="d-block py-3 text-white fs-sm fw-semibold bg-xeco" data-toggle="theme" data-theme="<?= $getThemeUrl('xeco') ?>" href="#">
                                      xEco
                                  </a>
                              </div>
                              <div class="col-4 mb-1">
                                  <a class="d-block py-3 text-white fs-sm fw-semibold bg-xsmooth" data-toggle="theme" data-theme="<?= $getThemeUrl('xsmooth') ?>" href="#">
                                      xSmooth
                                  </a>
                              </div>
                              <div class="col-4 mb-1">
                                  <a class="d-block py-3 text-white fs-sm fw-semibold bg-xinspire" data-toggle="theme" data-theme="<?= $getThemeUrl('xinspire') ?>" href="#">
                                      xInspire
                                  </a>
                              </div>
                              <div class="col-4 mb-1">
                                  <a class="d-block py-3 text-white fs-sm fw-semibold bg-xdream" data-toggle="theme" data-theme="<?= $getThemeUrl('xdream') ?>" href="#">
                                      xDream
                                  </a>
                              </div>
                              <div class="col-4 mb-1">
                                  <a class="d-block py-3 text-white fs-sm fw-semibold bg-xpro" data-toggle="theme" data-theme="<?= $getThemeUrl('xpro') ?>" href="#">
                                      xPro
                                  </a>
                              </div>
                              <div class="col-4 mb-1">
                                  <a class="d-block py-3 text-white fs-sm fw-semibold bg-xplay" data-toggle="theme" data-theme="<?= $getThemeUrl('xplay') ?>" href="#">
                                      xPlay
                                  </a>
                              </div>
                          </div>
                      </div>
                      <!-- END Color Themes -->

                      <!-- Sidebar -->
                      <div class="block-content block-content-sm block-content-full bg-body">
                          <span class="text-uppercase fs-sm fw-bold">Tùy chỉnh bảng điều khiển</span>
                      </div>
                      <div class="block-content block-content-full">
                          <div class="row g-sm custom-dashboard">
                              <div class="form-check form-switch">
                                  <label class="form-check-label">Tiêu đề <b>Cây trồng</b></label>
                                  <input class="form-check-input" type="checkbox" name="header-caytrong" checked>
                              </div>
                              <div class="form-check form-switch">
                                  <label class="form-check-label">Cây trồng: Số hộ trồng cây</label>
                                  <input class="form-check-input" type="checkbox" name="caytrong-sohotrongcay" checked>
                              </div>
                              <div class="form-check form-switch">
                                  <label class="form-check-label">Cây trồng: Quy trình sản xuất</label>
                                  <input class="form-check-input" type="checkbox" name="caytrong-quytrinhsanxuat" checked>
                              </div>
                              <div class="form-check form-switch">
                                  <label class="form-check-label">Cây trồng: Diện tích sản xuất</label>
                                  <input class="form-check-input" type="checkbox" name="caytrong-dientichsanxuat" checked>
                              </div>
                              <div class="form-check form-switch">
                                  <label class="form-check-label">Cây trồng:Thống kê theo <?= $capHanhchinh ?></label>
                                  <input class="form-check-input" type="checkbox" name="caytrong-thongkehanhchinh" checked>
                              </div>


                              <div class="form-check form-switch">
                                  <label class="form-check-label">Tiêu đề <b>Thủy sản</b></label>
                                  <input class="form-check-input" type="checkbox" name="header-thuysan" checked>
                              </div>
                              <div class="form-check form-switch">
                                  <label class="form-check-label">Thủy sản: Cơ sở nuôi cá tra</label>
                                  <input class="form-check-input" type="checkbox" name="thuysan-cosocatra" checked>
                              </div>
                              <div class="form-check form-switch">
                                  <label class="form-check-label">Thủy sản: Cơ sở nuôi cá lồng bè</label>
                                  <input class="form-check-input" type="checkbox" name="thuysan-cosocalongbe" checked>
                              </div>
                              <div class="form-check form-switch">
                                  <label class="form-check-label">Thủy sản:Thống kê theo <?= $capHanhchinh ?></label>
                                  <input class="form-check-input" type="checkbox" name="thuysan-thongkehanhchinh" checked>
                              </div>

                              <div class="form-check form-switch">
                                  <label class="form-check-label">Tiêu đề <b>Chăn nuôi</b></label>
                                  <input class="form-check-input" type="checkbox" name="header-channuoi" checked>
                              </div>
                              <div class="form-check form-switch">
                                  <label class="form-check-label">Chăn nuôi: Trang trại chăn nuôi heo</label>
                                  <input class="form-check-input" type="checkbox" name="channuoi-nuoiheo" checked>
                              </div>
                              <div class="form-check form-switch">
                                  <label class="form-check-label">Chăn nuôi:Thống kê theo <?= $capHanhchinh ?></label>
                                  <input class="form-check-input" type="checkbox" name="channuoi-thongkehanhchinh" checked>
                              </div>
                              <div class="form-check form-switch">
                                  <label class="form-check-label">Tiêu đề <b>Dữ liệu dùng chung</b></label>
                                  <input class="form-check-input" type="checkbox" name="header-dulieudungchung" checked>
                              </div>
                              <div class="form-check form-switch">
                                  <label class="form-check-label">Thửa đất</label>
                                  <input class="form-check-input" type="checkbox" name="dulieu-thuadat" checked>
                              </div>
                              <div class="form-check form-switch">
                                  <label class="form-check-label">Người dùng</label>
                                  <input class="form-check-input" type="checkbox" name="dulieu-nguoidung" checked>
                              </div>
                          </div>
                      </div>
                      <!-- END Sidebar -->


                  </div>
              </div>
              <!-- END Settings Tab -->




          </div>
      </div>
      <!-- END Side Overlay Tabs -->
  </div>