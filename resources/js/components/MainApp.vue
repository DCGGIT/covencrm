<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Lista de Tareas</div>

                    <div class="card-body">
                        <ul class="list-group">

                            <li v-for="(task, index) in tasks" :key="index" class="list-group-item d-flex justify-content-between align-items-center">
                                
                                {{task.description}}
                                
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <button type="button" class="btn btn-primary">Editar</button>
                                    <button type="button" class="btn btn-danger">Borrar</button>
                                </div>
                            </li>

                        </ul>
                        
                    </div>
                    <div class="card-fotter">

                        <div class="input-group p-3">
                            <input v-model="task.desc" type="text" class="form-control"  placeholder="nueva tarea">
                            <button class="btn btn-success mb-2"  @click="CreateItem()" type="button">Crear</button>
                            
                        </div>

                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            user:{}
        },
        data(){
            return{
                task:{
                    userID: 0,
                    desc: "",
                },
                tasks:[]
            }
        },
        mounted() {
            
            Echo.channel('items')
                .listen('ItemAdded', (e) => {

                    console.log(e.item)

                    var newTask = {
                        user_id: e.item.user_id,
                        description: e.item.description
                    }

                    this.tasks.push(newTask);

                });

            axios.get('/items')
            .then(response => {
                console.log("estas son las tareas cargadas. " + response.data);

                this.LoadItems(response.data);
            })
            .catch(e => {
                // Capturamos los errores
            })
        },
        methods: {
            LoadItems(_data){

                this.tasks = _data;

            },
            CreateItem() {
                axios.post('/cretate-item', {
                    user_id: this.user.id,
                    description: this.task.desc
                }).then(response => {

                    console.log("este es el mensaje: " + response.data);


                }).catch(e => {
                    console.log("Hay un error" + e);
                });
            }     
        }
    }
</script>
