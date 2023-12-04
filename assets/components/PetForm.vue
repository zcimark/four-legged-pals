<script setup lang="ts">
import PetFormInput from './PetFormInput.vue'
import DocumentationIcon from './icons/IconDocumentation.vue'
import ToolingIcon from './icons/IconTooling.vue'
import EcosystemIcon from './icons/IconEcosystem.vue'
import CommunityIcon from './icons/IconCommunity.vue'
import SupportIcon from './icons/IconSupport.vue'
import { ref, onMounted } from 'vue';

// Define a type for the pet object
interface Pet {
  name: string;
  type: string;
  breed: string;
  gender: string;
}

const pet = ref<Pet>({
  name: '',
  type: '',
  breed: '',
  gender: '',

});

export { pet }; 

const message = ref('');
const breeds = ref([]);

const props = defineProps<{
  petType: string
}>()

const breedSelection = ref('Known');
const isBreedInputVisible = ref(false);

const toggleBreedInput = (isUnknown: boolean): void => {
  isBreedInputVisible.value = isUnknown;
  // Reset the breed input when switching to Known Breed
  if (!isUnknown) {
    pet.breed = '';
  }
};


const submitForm = async () => {
  try {
    const response = await fetch('/pet/new', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        // You may need to include CSRF token headers if required
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

<!-- <template>
  <form @submit.prevent="submitForm">
    <label>Pet's name</label>
    <input v-model="pet.name" required />

    <label>Pet type</label>
    <select v-model="pet.type" required>
      <option value="Cat">Cat</option>
      <option value="Dog">Dog</option>
    </select>

    Add other form fields accordingly

    <button type="submit">Save Pet</button>
    <div v-if="message">{{ message }}</div>
  </form>
</template> -->
<template>
  <form @submit.prevent="submitForm">
    <PetFormInput>
      <template #icon>
        <DocumentationIcon />
      </template>
      <template #heading>What is your {{ petType }}'s name?</template>

      <input v-model="pet.name" required />
    </PetFormInput>

    <PetFormInput>
      <template #icon>
        <ToolingIcon />
      </template>
      <template #heading>What breed is your {{ petType }}?</template>

      <div>
      <!-- <label for="petBreed">Breed:</label> -->
      <select v-model="pet.breed" id="petBreed" required>
        <option value="">Select Breed</option>
        <option v-for="breed in breeds" :key="breed">{{ breed }}</option>
        <option value="unknown">Can't find it?</option>
      </select>
      </div>
      <div>
        <input type="radio" id="dontKnow" value="I don't know" v-model="pet.breed" :disabled="!isBreedInputVisible" />
        <label for="dontKnow"> I don't know</label>
      </div>
      <div>
        <input type="radio" id="itsAMix" value="It's a mix" v-model="pet.breed" :disabled="!isBreedInputVisible" />
        <label for="itsAMix"> It's a mix</label>
      </div>
      <div>
        <input type="text" v-model="pet.breed" id="petBreedInput" :disabled="!isBreedInputVisible"
          placeholder="Enter Breed" />
      </div>
      <br />
    </PetFormInput>

    <PetFormInput>
      <template #icon>
        <EcosystemIcon />
      </template>
      <template #heading>What gender are they?</template>

<br />
    </PetFormInput>

    <PetFormInput>
      <template #icon>
        <CommunityIcon />
      </template>
      <div class="form-group">
                <button class="btn btn-primary" type="submit">Submit</button>
      </div>

    </PetFormInput>
  </form>
</template>
