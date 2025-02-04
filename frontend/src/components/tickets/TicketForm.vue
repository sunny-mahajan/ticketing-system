<template>
  <div class="p-6 bg-white shadow-md rounded-md">
    <h2 class="text-lg font-bold mb-4">
      {{ isEditing ? "✏️ Edit Ticket" : "📝 Create Ticket" }}
    </h2>

    <input
      v-model="title"
      type="text"
      placeholder="Ticket Title"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:ring-blue-300 mb-3"
    />

    <textarea
      v-model="description"
      placeholder="Ticket Description"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:ring-blue-300 mb-3"
      rows="3"
    ></textarea>

    <!-- Status Field -->
    <label class="block mb-2 font-medium text-gray-700">Status</label>
    <select
      v-model="status"
      class="w-full p-2 border rounded focus:outline-none focus:ring focus:ring-blue-300 mb-4"
    >
      <option value="open">Open</option>
      <option value="in progress">In Progress</option>
      <option value="closed">Closed</option>
    </select>

    <div class="flex flex-col sm:flex-row gap-3 justify-end">
      <button
        @click="submit"
        :disabled="loading"
        class="flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition disabled:opacity-50"
      >
        <span v-if="loading" class="animate-spin h-5 w-5 mr-2">🔄</span>
        {{ loading ? "Saving..." : isEditing ? "Update Ticket" : "Create Ticket" }}
      </button>

      <button
        @click="$emit('cancel')"
        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded transition"
      >
        ❌ Cancel
      </button>
    </div>

    <p v-if="error" class="text-red-500 mt-4 text-center">{{ error }}</p>
  </div>
</template>

<script>
import { ref, watch } from "vue";
import { createTicket, updateTicket } from "@/services/ticketService";

export default {
  props: {
    ticket: Object, // If null, it's a new ticket
  },
  emits: ["ticketSaved", "cancel"],
  setup(props, { emit }) {
    const title = ref(props.ticket ? props.ticket.title : "");
    const description = ref(props.ticket ? props.ticket.description : "");
    const status = ref(props.ticket ? props.ticket.status : "open");
    const loading = ref(false);
    const error = ref(null);
    const isEditing = ref(!!props.ticket);

    watch(() => props.ticket, (newTicket) => {
      if (newTicket) {
        title.value = newTicket.title;
        description.value = newTicket.description;
        status.value = newTicket.status;
        isEditing.value = true;
      } else {
        title.value = "";
        description.value = "";
        status.value = "open";
        isEditing.value = false;
      }
    });

    const submit = async () => {
      if (!title.value || !description.value) {
        error.value = "Title and description are required!";
        return;
      }

      loading.value = true;
      error.value = null;

      try {
        const payload = {
          title: title.value,
          description: description.value,
          status: status.value,
        };

        if (isEditing.value) {
          await updateTicket(props.ticket.id, payload);
        } else {
          await createTicket(payload);
        }
        emit("ticketSaved");
      } catch (err) {
        error.value = "Error saving ticket. Please try again.";
      } finally {
        loading.value = false;
      }
    };

    return { title, description, status, loading, error, isEditing, submit };
  },
};
</script>
