<template>
    <div>
        <v-dialog v-model="open" max-width="600px">
            <v-card>
                <v-card-title class="popup-title">
                    {{ popupTitle }}
                    <v-spacer></v-spacer>
                    <v-btn icon @click="close">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>

                <v-card-text>
                    <v-form ref="form" v-model="valid" lazy-validation>
                        <v-text-field
                            label="Заголовок"
                            v-model="note.title"
                            :rules="[v => !!v || 'Заголовок обязателен']"
                            required
                        />
                        <v-textarea
                            label="Описание"
                            v-model="note.description"
                            :rules="[v => !!v || 'Описание обязательно']"
                            rows="3"
                            required
                        />
                        <v-radio-group
                            v-model="note.status"
                            row
                            :rules="[v => !!v || 'Выберите статус']"
                            label="Статус"
                            required
                        >
                            <v-radio label="Доступна" value="Allowed"></v-radio>
                            <v-radio label="Запрещена" value="Prohibited"></v-radio>
                        </v-radio-group>
                    </v-form>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text @click="close">Отмена</v-btn>
                    <v-btn color="primary" :disabled="!valid" @click="save">
                        {{ btnTitle }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: 'NotePopup',
    props: {
        itemId: {
            default: null,
            type: Number,
        }
    },
    data() {
        return {
            open: false,
            valid: false,
            note: {
                title: '',
                description: '',
                status: '',
            },
        }
    },
    computed: {
        popupTitle() {
            return this.itemId ? 'Обновить заметку' : 'Создать заметку';
        },
        btnTitle() {
            return this.itemId ? 'Обновить' : 'Создать';
        },
    },
    methods: {
        async save() {
            this.error = null
            try {
                if (this.noteId) {
                    await axios.patch(`http://localhost:8081/api/notes/${this.noteId}`, this.note)
                } else {
                    await axios.post('http://localhost:8081/api/notes', this.note).then(response => {
                        this.note = response.data.data;
                        this.noteId = response.data.data.id;
                    });
                }

                this.$emit('save')
                alert('Заметка успешно сохранена!')
                this.open = false;
            } catch (e) {
                this.error = 'Ошибка при сохранении заметки'
                alert(e);
            }
        },
        async loadItem(id) {
            try {
                await axios.get(`http://localhost:8081/api/notes/${id}`).then(response => {
                    this.note = response.data.data;
                });
            } catch (e) {
                throw e;
            }
        },
        close() {
            this.open = false;
        }
    },
    watch: {
        itemId: {
            handler(newNoteId) {
                this.note = { title: '', description: '', status: '' }

                if (newNoteId) {
                    this.loadItem(newNoteId)
                }
            }
        }
    },
}
</script>


<style scoped>
.popup-title {
    display: flex;
    align-items: center;
}
</style>
