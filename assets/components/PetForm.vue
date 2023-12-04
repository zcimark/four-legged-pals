<script setup lang="ts">
import PetFormInput from './PetFormInput.vue'
import DocumentationIcon from './icons/IconDocumentation.vue'
import IconPawPrint from './icons/IconPawPrint.vue';
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import { ref, onMounted } from 'vue';
import { useToast } from 'vue-toastification';
import 'vue-toastification/dist/index.css'

// Define a type for the pet object
interface Pet {
  name: string;
  type: string;
  breed: string;
  gender: string;
  mixedBreed: string;
}

const pet = ref<Pet>({
  name: '',
  type: '',
  breed: '',
  gender: '',
  mixedBreed: ''
});

const message = ref('');
const toast = useToast();
const breedEmit = defineEmits(['breedSelected']);

const props = defineProps<{
  petType: string
}>()

const breedSelection = ref('Known');
const isBreedInputVisible = ref(false);

const breeds = ref([]);


const fetchBreedData = async () => {
  try {
    pet.value.type = props.petType.toLowerCase();
    const response = await fetch('assets/static/' + (props.petType).toLowerCase() + '-breeds.json');
    if (!response.ok) {
      throw new Error(`Failed to fetch: ${response.status} ${response.statusText}`);
    }

    const data = await response.json();
    breeds.value = data;
  } catch (error) {
    console.error('Error fetching cat breeds:', error.message);
  }
};

// Call the fetchData function when the component is created
onMounted(fetchBreedData);

const handlePetName = () => {
  if (!pet.value.name) {
    toast.error('You must enter a name for your four legged pal.');
    return;
  }
}

const resetMixedBreed = () => {
  if (pet.value.breed !== "It's a mix") {
    pet.value.mixedBreed = '';
  }
}

const onSubmitForm = async () => {
  try {
    console.log(pet.value);
    const response = await fetch('/pet/post', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',

      },
      body: JSON.stringify(pet.value),
    });

    const data = await response.json();

    if (data.message) {
      message.value = data.message;
      // Optionally, reset the form or redirect to a new page
    } else if (data.errors) {
      console.error('Form submission errors:', data.errors);
      // Handle form validation errors
    }
  } catch (error) {
    console.error('Error submitting form:', error);
  }
};

</script>

<template>
  <form @submit.prevent="onSubmitForm">
    <PetFormInput>
      <template #icon>
        <IconPawPrint />
      </template>

      <template #heading>What is your {{ petType }}'s name?</template>


      <div class="pet-input">
        <input class="pet-input-box" v-model="pet.name" placeholder="Enter your Four Legged Pal's Name" required />
      </div>
    </PetFormInput>

    <PetFormInput>
      <template #icon>
        <IconPawPrint />
      </template>
      <template #heading>What breed is your {{ petType }} {{ pet.name }}?</template>

      <div style="background: #282c34; padding: 1rem; border-radius: 0.3rem">
        <v-select @click="handlePetName" v-model="pet.breed" :options="breeds" required>
        </v-select>
      </div>

      <div v-if="pet.breed == 'Can\'t find it?' || pet.breed == 'I don\'t know'">
        <div>
          Choose One
        </div>
        <input type="radio" id="dontKnow" value="I don't know" v-model="pet.breed" />
        <label for="dontKnow"> I don't know</label>
      </div>
      <div>
        <input type="radio" id="itsAMix" v-model="pet.breed" value="Can't find it?" @change="resetMixedBreed" />
        <label for="itsAMix"> It's a mix</label>
        <div class="pet-input">
          <input class="pet-input-box" type="text" id="petBreedInput" v-model="pet.mixedBreed"
            placeholder="Enter the mix here!" />
        </div>
      </div>

      <br />
    </PetFormInput>

    <PetFormInput>
      <template #icon>
        <IconPawPrint />
      </template>
      <template #heading>What gender are they?</template>

      <div>
        <input type="radio" id="male" v-model="pet.gender" value="male" @change="resetMixedBreed" />
        <label for="male"> Male</label>
</div>
<div>
        <input type="radio" id="itsAMix" v-model="pet.gender" value="female" @change="resetMixedBreed" />
        <label for="female"> Female</label>

      </div>
      <br />
    </PetFormInput>

    <PetFormInput>
      <template #icon>
        <IconPawPrint />
      </template>
      <div class="form-group">
        <button class="submit-button" type="submit">Continue</button>
      </div>

    </PetFormInput>
  </form>
</template>

<style scoped>
:deep() {
  --vs-controls-color: #664cc3;
  --vs-border-color: #664cc3;

  --vs-dropdown-bg: #282c34;
  --vs-dropdown-color: #cc99cd;
  --vs-dropdown-option-color: #cc99cd;

  --vs-selected-bg: #664cc3;
  --vs-selected-color: #eeeeee;

  --vs-search-input-color: #eeeeee;

  --vs-dropdown-option--active-bg: #664cc3;
  --vs-dropdown-option--active-color: #eeeeee;
}

.pet-input-box {
  padding: 8px;
  border-color: #664cc3;
  border-width: 1.5px;
  border-radius: 4px;
  font-size: 14px;
  background: #282c34;
  width: 100%;
  color: white !important;
}

.pet-input {
  padding: 8px;
  border-radius: 4px;
  font-size: 14px;
  background: #282c34;
  width: 100%;
  color: white;
}

.submit-button {
  background-color: #4c96af;
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s;
}

.submit-button:hover {
  background-color: #664cc3;
}
</style>