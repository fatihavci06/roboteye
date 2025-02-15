<template>
  <div>
    <VCard title="Employes 🙌">
      <v-container>
        <!-- CREATE employe BUTTON -->
        <v-btn color="primary" class="mb-4" @click="dialog = true" style="float: inline-end;">
          Create employe
        </v-btn>

        <!-- employe DATA TABLE -->
        <v-data-table :headers="headers" :items="dataStore.data" :items-per-page="15" :page="dataStore.currentPage"
          :loading="dataStore.loading">
          <template v-slot:item.company="{ item }">
            <v-chip>{{ item.company.name }}</v-chip>
          </template>
        </v-data-table>

        <!-- PAGINATION -->
        <v-pagination v-model="dataStore.currentPage" :length="dataStore.totalPages"
          @update:modelValue="dataStore.fetchData" />
      </v-container>
    </VCard>

    <!-- DIALOG FOR CREATING employe -->
    <v-dialog v-model="dialog" max-width="600px">
      <v-card>
        <v-card-title>Create employe</v-card-title>
        <v-card-text>
          <v-form ref="employeForm">
            <v-row dense>
              <v-col cols="12" class="d-flex align-center">
                <label class="mr-4 text-body-1 font-weight-medium" style="inline-size: 150px;">First Name:</label>
                <v-text-field v-model="employe.first_name" variant="solo" density="compact" class="flex-grow-1"
                  :error-messages="dataStore.errors.first_name" required />
              </v-col>

              <v-col cols="12" class="d-flex align-center">
                <label class="mr-4 text-body-1 font-weight-medium" style="inline-size: 150px;">Last Name:</label>
                <v-text-field v-model="employe.last_name" variant="solo" density="compact" class="flex-grow-1"
                  :error-messages="dataStore.errors.last_name" required />
              </v-col>

              <v-col cols="12" class="d-flex align-center">
                <label class="mr-4 text-body-1 font-weight-medium" style="inline-size: 150px;">Email:</label>
                <v-text-field v-model="employe.email" variant="solo" density="compact" type="email" class="flex-grow-1"
                  :error-messages="dataStore.errors.email" required />
              </v-col>

              <v-col cols="12" class="d-flex align-center">
                <label class="mr-4 text-body-1 font-weight-medium" style="inline-size: 150px;">Phone:</label>
                <v-text-field v-model="employe.phone" variant="solo" density="compact" class="flex-grow-1"
                  :error-messages="dataStore.errors.phone" required />
              </v-col>

              <v-col cols="12" class="d-flex align-center">
                <label class="mr-4 text-body-1 font-weight-medium" style="inline-size: 150px;">Company:</label>
                <v-select v-model="employe.company_id" :items="companies" item-title="name" item-value="id"
                  :error-messages="dataStore.errors.company_id" variant="solo" density="compact" class="flex-grow-1"
                  required />
              </v-col>
            </v-row>
          </v-form>

        </v-card-text>
        <v-card-actions>

          <v-btn @click="dialog = false" color="red" variant="outlined">Cancel</v-btn>
          <v-btn @click="saveemploye" color="green" variant="elevated">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { useCompanyStore } from "@/stores/companyStore";
import { useEmployeStore } from "@/stores/employeStore";
import { onMounted, ref, watch } from "vue";
export default {
  setup() {
    const dataStore = useEmployeStore();
    const companyStore = useCompanyStore();
    const dialog = ref(false);
    const employe = ref({
      first_name: "",
      last_name: "",
      email: "",
      phone: "",
      company_id: null,
    });



    const fetchCompanies = async () => {
      try {
        companies.value = companyStore.fetchData();
      } catch (error) {
        console.error("Şirketleri alırken hata oluştu", error);
      }
    };

    const companies = computed(() => companyStore.data);

    const saveemploye = async () => {
      try {
        await dataStore.createEmploye(employe.value); 
        await dataStore.fetchData(dataStore.currentPage); 
       
        employe.value = { // Formu temizle
          first_name: "",
          last_name: "",
          email: "",
          phone: "",
          company_id: null,
        };
        
      } catch (error) {

        dialog.value = true;
        console.error("Çalışan kaydedilirken hata oluştu:", error);
      }
    };

    const headers = [
      { title: "First Name", key: "first_name" },
      { title: "Last Name", key: "last_name" },
      { title: "E-posta", key: "email" },
      { title: "Phone", key: "phone" },
      { title: "Company", value: "company.name" },
    ];

    onMounted(() => {
      dataStore.fetchData(dataStore.currentPage);
      fetchCompanies();
    });

    watch(
      () => dataStore.currentPage,
      (newPage) => {
        console.log("Sayfa değişti:", newPage);
        dataStore.fetchData(newPage);
      }
    );

    return {
      dataStore,
      headers,
      dialog,
      employe,
      companies,
      saveemploye,
      companyStore
    };
  },
};
</script>
