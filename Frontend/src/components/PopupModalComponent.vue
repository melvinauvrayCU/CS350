<script lang = "ts">
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";


export default {
  name: "PopupModal",
  components: {
    CustomButton
  },
};

</script>


<template>
  <transition name="modal-fade">
    <div class="modal-overlay">
      <div class="modal">
        <div class="header">
          <h2>Are you sure you want to delete this recipe?</h2>
          <div class="btn-close">
            <CustomButton type="danger" effect="inline" text="" titleText="Close category" icon="x"
              @clicked="$emit('close-modal')" />
          </div>
          <div class="btn-confirm">
            <CustomButton type="success" effect="empty" text="confirm" titleText="confirm"
              @clicked="$emit('confirm-modal')" />

          </div>
          <div class="btn-cancel">
            <CustomButton type="neutral" effect="empty" text="cancel" titleText="cancel"
              @clicked="$emit('cancel-modal')" />

          </div>

        </div>

      </div>

    </div>
  </transition>
</template>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.3);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2;
}

.modal {
  width: 30%;
  height: 15%;
  border-radius: 25px;
  background: var(--color-background);
  box-shadow: 2px 2px 20px 1px;
  overflow-x: auto;
  display: flex;
  flex-direction: column;
  padding: 10px;
  position: relative;
  z-index: 3;
}

.header {
  flex-direction: row;
  justify-content: space-between;
  position: relative;
  background-color: transparent;
  align-items: baseline;
  padding: 5px;
}

.header h2 {
  text-align: center;

}

.btn-close {
  position: absolute;
  top: 1px;
  right: 0;
  padding-top: 5px;
  padding-right: 10px;
}


.btn-cancel {
  margin-top: 10px;
  width: 50%;
  float: left;
}

.btn-confirm {
  margin-top: 10px;
  width: 50%;
  float: left;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: all 0.5s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}
</style>
