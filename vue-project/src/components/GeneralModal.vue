<template>
  <v-dialog v-model="isOpen" max-width="500px">
    <v-card>
      <v-card-title class="headline">Create Something</v-card-title>
      <v-card-text>
        <!-- Modal İçeriği -->
        <v-text-field label="Name" v-model="formData.name"></v-text-field>
        <!-- Diğer form alanları -->
      </v-card-text>
      <v-card-actions>
        <v-btn @click="$emit('close')" color="green darken-1">Close</v-btn>
        <v-btn @click="submitForm" color="blue darken-1">Save</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    isOpen: Boolean,
  },
  data() {
    return {
      formData: {
        name: '',
      },
    };
  },
  methods: {
    submitForm() {
      // Formu gönderme işlemleri
      this.$emit('close');
    },
  },
};
</script>
