<template>
    <base-layout>
        <template #content>
            <div class="header-title">
                <h1>Заметки</h1>
                <div style="display: flex; align-items: center; gap: 16px">
                    <v-btn color="primary" @click="openPopup(null)" style="cursor: pointer;">Создать заметку</v-btn>

                    <v-btn icon @click="deleteAll" style="cursor: pointer;">
                        <v-icon>mdi-delete-sweep-outline</v-icon>
                        <v-tooltip activator="parent" location="top">
                            Удалить все заметки
                        </v-tooltip>
                    </v-btn>

                    <v-btn icon @click="generate" style="cursor: pointer;">
                        <v-icon>mdi-text-box-plus-outline</v-icon>
                        <v-tooltip activator="parent" location="top">
                            Сгенерировать заметки
                        </v-tooltip>
                    </v-btn>

                    <NotePopup
                        ref="notePopup"
                        :itemId="itemId"
                        @save="save"
                    />
                </div>
            </div>
            <div>
                <NoteList
                    ref="noteList"
                    @edit="openPopup($event.id)"
                />
            </div>
        </template>
    </base-layout>
</template>

<script>
import BaseLayout from "../layouts/BaseLayout.vue";
import NotePopup from '../components/NotePopup.vue'
import NoteList from "../components/NoteList.vue";
import axios from "axios";

export default {
    name: 'NotePage',
    data() {
        return {
            itemId: null,
        };
    },
    methods: {
        openPopup(itemId = null) {
            this.itemId = itemId;
            this.$refs.notePopup.open = true;
        },
        save() {
            this.$refs.noteList.onLoadData();
        },
        async generate() {
            if (confirm('Вы уверены, что хотите сгенерировать 1000 заметок?')) {
                await axios.post('http://localhost:8081/api/generate').then(() => {
                    this.$refs.noteList.onLoadData();
                    alert('Заметки успешно сгенерированы');
                }).catch(e => {
                    console.log(e)
                });
            }
        },
        async deleteAll() {
            if (confirm('Вы уверены, что хотите удалить все заметки?')) {
                await axios.delete('http://localhost:8081/api/clear').then(() => {
                    this.$refs.noteList.onLoadData();
                    alert('Заметки успешно удалены');
                }).catch(e => {
                    console.log(e)
                });
            }
        },
    },
    components: {
        NoteList,
        BaseLayout,
        NotePopup,
    },
}
</script>

<style scoped>
.header-title {
    display: flex;
    justify-content: space-between;
}

.header-title h1 {
    font-size: 26px;
}
</style>
