<template>
  <div class="container mx-auto px-4 py-6">
    <!-- Header with Title and Create Button -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">🎟️ Ticket List</h1>
      <button
        v-if="!showForm"
        @click="openForm()"
        class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-lg font-bold py-3 px-6 rounded-lg shadow-lg transition"
      >
        + New Ticket
      </button>
    </div>

    <!-- Search and Filter Section -->
    <div class="flex flex-col md:flex-row gap-4 mb-6 items-center">
      <!-- Search Input -->
      <input
        v-model="searchQuery"
        type="text"
        placeholder="🔍 Search tickets..."
        class="w-full md:w-2/3 p-2 border rounded focus:outline-none focus:ring focus:ring-blue-300"
      />

      <!-- Status Filter -->
      <select
        v-model="selectedStatus"
        class="w-full md:w-1/3 p-2 border rounded focus:outline-none focus:ring focus:ring-blue-300"
      >
        <option value="">All Statuses</option>
        <option value="open">Open</option>
        <option value="in progress">In Progress</option>
        <option value="closed">Closed</option>
      </select>
    </div>

    <!-- Ticket Form Modal -->
    <transition name="fade">
      <div v-if="showForm" class="fixed inset-0 flex items-center justify-center z-50 px-4">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative bg-white rounded-lg shadow-xl p-6 w-full max-w-3xl">
          <TicketForm :ticket="selectedTicket" @ticketSaved="handleTicketSaved" @cancel="closeForm" />
        </div>
      </div>
    </transition>

    <!-- Loader While Fetching Tickets -->
    <div v-if="loading" class="flex justify-center items-center py-6">
      <span class="animate-spin text-3xl mr-2">🔄</span>
      <span class="text-xl font-semibold">Loading tickets...</span>
    </div>

    <!-- Filtered Ticket List -->
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="ticket in filteredTickets"
        :key="ticket.id"
        class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-150"
      >
        <h2 class="text-xl font-bold mb-1">{{ ticket.title }}</h2>
        <p class="text-gray-700 mb-2">{{ ticket.description }}</p>
        
        <!-- Status Badge -->
        <span
          class="inline-block px-3 py-1 text-sm font-semibold rounded-full"
          :class="statusClass(ticket.status)"
        >
          {{ ticket.status }}
        </span>

        <!-- Edit & Delete Buttons -->
        <div class="flex justify-end space-x-2 mt-3">
          <button @click="openForm(ticket)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded transition duration-150">
            ✏️ Edit
          </button>
          <button @click="confirmDelete(ticket.id)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded transition duration-150">
            🗑️ Delete
          </button>
        </div>
      </div>
    </div>

    <!-- No Tickets Found Message -->
    <p v-if="filteredTickets.length === 0 && !loading" class="text-center text-gray-500 mt-6">No tickets found.</p>
  </div>
</template>

<script>
import { ref, computed, onMounted } from "vue";
import { getTickets, deleteTicket } from "@/services/ticketService";
import TicketForm from "@/components/tickets/TicketForm.vue";

export default {
  components: { TicketForm },
  setup() {
    const tickets = ref([]);
    const showForm = ref(false);
    const selectedTicket = ref(null);
    const loading = ref(false);
    const searchQuery = ref("");
    const selectedStatus = ref("");

    const loadTickets = async () => {
      loading.value = true;
      try {
        tickets.value = await getTickets();
      } catch (error) {
        console.error("Error fetching tickets:", error);
      } finally {
        loading.value = false;
      }
    };

    const filteredTickets = computed(() => {
      return tickets.value.filter(ticket => {
        const matchesSearch = ticket.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                              ticket.description.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesStatus = selectedStatus.value ? ticket.status === selectedStatus.value : true;
        return matchesSearch && matchesStatus;
      });
    });

    const openForm = (ticket = null) => {
      selectedTicket.value = ticket;
      showForm.value = true;
    };

    const closeForm = () => {
      showForm.value = false;
    };

    const handleTicketSaved = () => {
      closeForm();
      loadTickets(); // Reload tickets after update/create
    };

    const confirmDelete = async (id) => {
      if (window.confirm("Are you sure you want to delete this ticket?")) {
        await deleteTicket(id);
        loadTickets(); // Reload tickets after deletion
      }
    };

    const statusClass = (status) => ({
      "bg-green-200 text-green-800": status === "open",
      "bg-yellow-200 text-yellow-800": status === "in progress",
      "bg-red-200 text-red-800": status === "closed",
    });

    onMounted(loadTickets);

    return {
      tickets,
      showForm,
      selectedTicket,
      openForm,
      closeForm,
      handleTicketSaved,
      confirmDelete,
      loading,
      searchQuery,
      selectedStatus,
      filteredTickets,
      statusClass
    };
  },
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
