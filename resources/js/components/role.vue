<template lang="">
    <form>
        <div class="modal-body">
            <div class="form-group">
                <input
                    v-model="form.name"
                    type="text"
                    name="name"
                    placeholder="Role Name"
                    class="form-control"
                    :class="{ 'is-invaild': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
            </div>

            <b-form-group label="Assign Permissions">
                <b-form-checkbox
                    v-for="option in permissions"
                    v-model="form.permissions"
                    :key="option.name"
                    :value="option.name"
                    name="flavour-3a"
                >
                    {{ option.name }}
                </b-form-checkbox>
            </b-form-group>
        </div>
        <div class="modal-footer justify-content-between">
            <b-button
                type="submit"
                variant="primary"
                class="btn-lg btn-primary"
                v-if="!dis"
                disabled
                ><b-spinner small type="grow"></b-spinner>Creating
                Role</b-button
            >
            <button
                type="submit"
                v-if="dis"
                @click.prevent="createRole()"
                class="btn btn-lg btn-primary"
            >
                <i class="fas fa-save"></i> Save Role
            </button>
        </div>
    </form>
</template>
<script>
import Vue from "vue";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

import { Form, HasError, AlertError } from "vform";
import Swal from "sweetalert2";
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: toast => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    }
});
export default {
    data() {
        return {
            dis: true,
            permissions: [],
            form: new Form({
                name: "",
                permissions: []
            })
        };
    },
    methods: {
        getPermissions() {
            axios
                .get("/getAllPermissions")
                .then(response => {
                    this.permissions = response.data.permissions;
                })
                .catch(() => {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                });
        },
        createRole() {
            this.dis = false;

            this.form
                .post("/postRole")
                .then(() => {
                    Swal.fire({
                        icon: "success",
                        title: "Role Successfully Created",
                        text: "Your Role has been created"
                    });
                    window.location= "/role";
                })
                .catch(() => {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                });

            this.dis = true;
        }
    },
    created() {
        this.getPermissions();
    }
};
</script>
<style lang=""></style>
