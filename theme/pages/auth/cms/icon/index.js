Vue.component("media-box", {
    template: /*html */ `
      <div class="modal fade" id="media-box-modal" tabindex="-1"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{currentMedia.title}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="$emit('close')"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-7">
              <img style="object-fit:scale-down; width: 100%; background-color: hsl(0, 0%, 90%);" class="p-3" :src="currentMedia.url" >
            </div>
            <div class="col-md-5 font-size-sm">
                <div class="form-group mb-2">
                  <label class="m-0">Title</label>
                  <input class="form-control" required v-model="currentMedia.title">
                </div>
                <div class="form-group mb-2">
                  <label class="m-0">Mine Type</label>
                  <div>{{currentMedia.mine_type}}</div>
                </div>
                <div class="form-group mb-2">
                  <label class="m-0">Updated At</label>
                  <div>{{updatedAt}}</div>
                </div>
                 <div class="form-group mb-2">
                  <label class="m-0">File size</label>
                  <div>{{size}}</div>
                </div>
                 <div class="form-group mb-2">
                  <label class="m-0">Size</label>
                  <div>{{currentMedia.width}}x{{currentMedia.height}}</div>
                </div>
                <div class="form-group mb-2">
                  <label class="m-0">Url</label>
                  <div class="input-group">
                    <input class="form-control" readonly v-model="currentMedia.url">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-secondary" @click="copyToClipboard">{{copyText}}</button>
                    </div>
                  </div>
                   <a :href="currentMedia.url" class="btn btn-secondary mt-2" download>Download</a>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="$emit('change', currentMedia)">Lưu</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="$emit('close')">Đóng</button>
        </div>
      </div>
    </div>
  </div>
      `,
    props: {
      media: {
        type: Object,
      },
      isShow: {
        type: Boolean,
        default: false,
      },
    },
    data() {
      return {
        currentMedia: {
          size: 0,
          updated_at: 1000000000,
          title: "",
        },
        copyText: "Copy",
      };
    },
    computed: {
      updatedAt() {
        return new Date(this.currentMedia.updated_at * 1000).toLocaleString();
      },
      size() {
        return Math.round((this.currentMedia.size / 1024) * 100) / 100 + " KB";
      },
    },
    mounted() {
      if (this.media) {
        this.currentMedia = { ...media };
      }
    },
    watch: {
      isShow(isShow) {
        if (isShow) {
          $("#media-box-modal").modal("show");
        }
      },
      media(media) {
        this.currentMedia = { ...media };
        this.copyText = "Copy";
      },
    },
    methods: {
      copyToClipboard() {
        navigator.clipboard.writeText(this.currentMedia.url);
        this.copyText = "Copied";
      },
    },
  });
  
  Vue.component("media-confirm", {
    template: /*html */ `
    <div class="modal fade" id="media-confirm-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Xác nhận</h5>
      
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="$emit('close')"></button>
          </div>
          <div class="modal-body">
            {{message}}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="$emit('close')">Không</button>
            <button type="button" class="btn btn-primary"  data-bs-dismiss="modal" @click="$emit('confirm')">Có</button>
          </div>
        </div>
      </div>
    </div>
    `,
    props: {
      isShow: {
        type: Boolean,
        default: false,
      },
      message: {
        type: String,
        default: "Bạn có chắc muốn xóa hình ảnh này?",
      },
    },
    watch: {
      isShow(isShow) {
        if (isShow) {
          $("#media-confirm-modal").modal("show");
        }
      },
    },
  });
  
  Vue.component("media-gallery", {
    template: /*html */ `
    <div >
      <div class="row no-gutters">
        <div
          class="col-md-2 p-1 animated fadeIn"
          v-for="media in medias"
          :key="media.id"
        >
          <div class="media-thumbnail card options-container fx-item-zoom-in" >
            <div class="media-thumbnail-inner">
              <div class="media-thumbnail-inner-center px-3 py-2" style="background-color: hsl(0, 0%, 90%);">
                <img :src="media.url" class="options-item" style="width:100%;height:100%;">
               
              </div>
               <div class="p-1 font-size-sm">{{media.title}}</div>
            </div>
            <div class="options-overlay bg-black-75">
              <div class="options-overlay-content">
                  <button class="btn btn-sm btn-primary" title="Edit" @click="openDetails(media)">
                      <i class="fa fa-pencil-alt "></i> 
                  </button>
                  <button class="btn btn-sm btn-danger" title="Delete" @click="openConfirm(media)">
                      <i class="fa fa-times "></i> 
                  </button>
              </div>
            </div>
           
          </div>
        </div>
      </div>
      <media-box
        :media="currentMedia"
        @change="updateMedia"
        @close="showDetails=false"
        :is-show="showDetails"
      />
       <media-confirm 
        @confirm="deleteMedia" 
        @close="showConfirm=false"  
        :is-show="showConfirm">
      </media-confirm>
    </div>
      `,
    props: {
      medias: {
        type: Array,
        required: true,
      },
    },
    data() {
      return {
        showDetails: false,
        currentMedia: null,
        showConfirm: false,
      };
    },
    methods: {
      openDetails(media) {
        this.showDetails = true;
        this.currentMedia = media;
      },
      openConfirm(media) {
        this.showConfirm = true;
        this.currentMedia = media;
      },
      deleteMedia() {
        this.$emit("deletemedia", this.currentMedia);
        this.showConfirm = false;
      },
      updateMedia(item) {
        this.$emit("updatemedia", item);
        this.showDetails = false;
      },
    },
  });
  
  Vue.component("file-gallery", {
    template: /*html */ `
    <div >
      <div class="row no-gutters">
        <div
          class="col-md-2 p-1 animated fadeIn"
          v-for="media in medias"
          :key="media.id"
        >
          <div class="media-thumbnail card options-container fx-item-zoom-in" >
            <div class="media-thumbnail-inner text-center">
              <div class="media-thumbnail-inner-center px-3 py-2">
                <img src="/resources/images/icons8-xml-file-48.png" class="options-item" >
               
              </div>
               <div class="p-1 font-size-sm">{{media.title}}</div>
            </div>
            <div class="options-overlay bg-black-75">
              <div class="options-overlay-content">
                  <button class="btn btn-sm btn-danger" title="Delete" @click="openConfirm(media)">
                      <i class="fa fa-times "></i> 
                  </button>
              </div>
            </div>
           
          </div>
        </div>
      </div>
      
       <media-confirm 
        @confirm="deleteMedia" 
        @close="showConfirm=false" 
        message="Bạn có chắc muốn xóa file này?"
        :is-show="showConfirm">
      </media-confirm>
    </div>
      `,
    props: {
      medias: {
        type: Array,
        required: true,
      },
    },
    data() {
      return {
        showDetails: false,
        currentMedia: null,
        showConfirm: false,
      };
    },
    methods: {
      openConfirm(media) {
        this.showConfirm = true;
        this.currentMedia = media;
      },
      deleteMedia() {
        this.$emit("deletemedia", this.currentMedia);
        this.showConfirm = false;
      },
      updateMedia(item) {
        this.$emit("updatemedia", item);
        this.showDetails = false;
      },
    },
  });
  