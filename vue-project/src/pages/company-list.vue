<template>
<div>
    <VCard title="Companies 🙌">
        <v-container>

            <v-btn color="primary" class="mb-4" @click="dialog = true" style="float: inline-end;">
                Company Create
            </v-btn>

            <!-- v-dialog -->
            <v-dialog v-model="dialog" max-width="500">
                <v-card class="rounded-lg">
                    <v-card-title class="text-h5 py-4 px-6 font-weight-bold">
                        Company Create
                    </v-card-title>

                    <v-divider></v-divider>

                    <v-card-text class="pa-6">
                      <v-form ref="companyForm">
                        <v-row dense>
                          <v-col cols="12" class="d-flex align-center">
                            <label class="mr-4 text-body-1 font-weight-medium" style="inline-size: 150px;">Company Name:</label>
                            <v-text-field 
                              v-model="company.name" 
                              variant="solo" 
                              density="compact"
                              hide-details="auto" 
                              class="flex-grow-1"
                              :error-messages="dataStore.errors.name"
                              required 
                            />
                          </v-col>

                          <v-col cols="12" class="d-flex align-center">
                            <label class="mr-4 text-body-1 font-weight-medium" style="inline-size: 150px;">Email:</label>
                            <v-text-field  
                              v-model="company.email" 
                              type="email" 
                              variant="solo"
                              density="compact"
                              hide-details="auto"  
                              class="flex-grow-1"
                              :error-messages="dataStore.errors.email"
                              required 
                            />
                          </v-col>

                          <v-col cols="12" class="d-flex align-center">
                            <label class="mr-4 text-body-1 font-weight-medium" style="inline-size: 150px;">Website:</label>
                            <v-text-field  
                              v-model="company.website" 
                              variant="solo"
                              density="compact"
                              hide-details="auto"  
                              class="flex-grow-1"
                              :error-messages="dataStore.errors.website"
                              required 
                            />
                          </v-col>

                          <v-col cols="12" class="d-flex align-center">
                            <label class="mr-4 text-body-1 font-weight-medium" style="inline-size: 150px;">Company Logo:</label>
                            <v-file-input  
                              v-model="company.logo"
                              variant="solo" 
                              density="compact"
                              hide-details="auto"  
                              class="flex-grow-1"
                              accept="image/png, image/jpeg, image/jpg, image/svg+xml"
                              show-size 
                              :error-messages="dataStore.errors.logo"
                              @change="handleFileUpload"
                              prepend-icon=""
                              required
                            />
                          </v-col>
                        </v-row>
                      </v-form>
                    </v-card-text>


                    <v-divider></v-divider>

                    <v-card-actions class="pa-4 d-flex justify-end">
                        <v-btn color="red" variant="outlined" @click="dialog = false">
                            Cancel
                        </v-btn>
                        <v-btn color="green" variant="elevated" @click="createCompany">
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <!-- DataTable -->
            <v-data-table :headers="headers" :items="dataStore.data" :items-per-page="15" :page="dataStore.currentPage" :loading="dataStore.loading">
                <template v-slot:item.name="{ item }">
                    <v-chip>{{ item.name }}</v-chip>
                </template>

                <template v-slot:item.logo="{ item }">
                    <a :href="getImageUrl(item.logo)" target="_blank" rel="noopener noreferrer">
                        <v-img :src="getImageUrl(item.logo)" alt="Company Logo" width="100" height="75" contain />
                    </a>
                </template>
            </v-data-table>

            <!-- Sayfalama -->
            <v-pagination v-model="dataStore.currentPage" :length="dataStore.totalPages" @update:modelValue="dataStore.fetchData" />
        </v-container>
    </VCard>
</div>
</template>

<script>
import {
useCompanyStore
} from "@/stores/companyStore";
import {
onMounted,
ref,
watch
} from "vue";

export default {
    setup() {
        const dataStore = useCompanyStore();
        const dialog = ref(false);
        const company = ref({
            name: '',
            email: '',
            website: '',
            logo: null,
        });

        const headers = ref([{
                title: "Name",
                value: "name"
            },
            {
                title: "Email",
                value: "email"
            },
            {
                title: "Logo",
                value: "logo"
            },
            {
                title: "Website",
                value: "website"
            }
        ]);

        const handleFileUpload = (event) => {
            const file = event.target.files[0];
            if (file) {
                company.value.logo = file;
            }
        };
        const createCompany = async () => {
            try {
                const formData = new FormData();
                formData.append("name", company.value.name);
                formData.append("email", company.value.email);
                formData.append("website", company.value.website);

                if (company.value.logo) {
                    formData.append("logo", company.value.logo);
                }

                 await dataStore.createCompany(formData);
                 await dataStore.fetchData();
                 

                company.value = {
                    name: '',
                    email: '',
                    website: '',
                    logo: null
                };
                dialog.value = false;
            } catch (error) {
                
                console.error('Şirket oluşturulamadı:', error);
            }
        };

        const baseURL = "http://localhost:8000/storage/";
        const getImageUrl = (path) => (path ? `${baseURL}${path}` : "-");

        onMounted(() => {
            dataStore.fetchData(dataStore.currentPage);
        });

        watch(() => dataStore.currentPage, (newPage) => {
            console.log("Sayfa değişti:", newPage);
            dataStore.fetchData(newPage);
        });

        return {
            dataStore,
            headers,
            dialog,
            company,
            handleFileUpload,
            createCompany,
            getImageUrl
        };
    },
};
</script>
l
