<template>
    <v-container>
        <v-data-table
            :headers="headers"
            :items="notes"
            item-value="id"
            class="elevation-1"
        >
            <template #item.status="{ item }">
                <v-chip :color="item.status === 'Allowed' ? 'success' : 'warning'" dark>
                    {{ item.status === 'Allowed' ? 'Доступна' : 'Запрещена' }}
                </v-chip>
            </template>

            <template #item.actions="{ item }">
                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                    <v-icon
                        small
                        class="mr-2"
                        @click="$emit('edit', item)"
                        style="cursor: pointer;"
                    >
                        mdi-pencil
                    </v-icon>

                    <v-icon
                        small
                        @click="onDelete(item)"
                        style="cursor: pointer;"
                    >
                        mdi-delete
                    </v-icon>
                </div>
            </template>
        </v-data-table>
    </v-container>
</template>

<script>
import axios from "axios";

export default {
    name: 'NoteList',
    props: {
        itemId: {
            default: null,
            type: Number,
        },
    },
    data() {
        return {
            notes: [],
            headers: [
                {title: 'ID', value: 'id'},
                {title: 'Заголовок', value: 'title'},
                {title: 'Описание', value: 'description'},
                {title: 'Статус', value: 'status'},
                {title: '', value: 'actions', sortable: false, align: 'end'}
            ],
        }
    },
    mounted() {
        this.onLoadData();
    },
    methods: {
        async loadData() {
            return await axios.get('http://localhost:8081/api/notes');
        },
        onLoadData() {
            this.loadData().then(response => {
                this.notes = response.data.data;
            });
        },
        async onDelete(item) {
            if (!confirm(`Вы уверены что хотите безвозвратно удалить записку ${item.title} (${item.id})`)) {
                return;
            }

            await axios.delete(`http://localhost:8081/api/notes/${item.id}`).then(() => {
                this.onLoadData();
                alert('Записка успешно удалена');
            }).catch(e => {
                alert(e);
            });
        }
    },
}
</script>

<style scoped>

</style>
