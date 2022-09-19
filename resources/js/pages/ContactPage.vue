<template>
    <div class="container">
        <h1>Contact</h1>

        <div v-if='success' class="alert alert-success" role="alert">
            Thanks for contacting us!
        </div>

        <form @submit.prevent="sendMessage()">
            <div class="mb-3">
                <label for="user-name" class="form-label">Name</label>
                <input v-model="userName" type="text" class="form-control" id="user-name">

                <div v-if="errors.name">
                    <div v-for="(error, index) in errors.name" :key="index" class="alert alert-danger" role="alert">
                        {{ error }}
                    </div>  
                </div>
            </div>
            <div class="mb-3">
                <label for="user-mail" class="form-label">Email address</label>
                <input v-model="userEmail" type="email" class="form-control" id="user-mail">

                <div v-if="errors.email">
                    <div v-for="(error, index) in errors.email" :key="index" class="alert alert-danger" role="alert">
                        {{ error }}
                    </div>  
                </div>
            </div>
            <div class="mb-3">
                <label for="user-content" class="form-label">Content</label>
                <textarea v-model="userMessage" class="form-control" id="user-content" rows="8"></textarea>

                <div v-if="errors.message">
                    <div v-for="(error, index) in errors.message" :key="index" class="alert alert-danger" role="alert">
                        {{ error }}
                    </div>  
                </div>
            </div>
            
            <input type="submit" value="Submit" class="btn btn-primary" :disabled="sending">
        </form>
    </div>
</template>

<script>
export default {
    name: 'ContactPage',
    data()  {
        return {
            userName: '',
            userEmail: '',
            userMessage: '',
            success: false, 
            errors: {},
            sending: false
        };
    },
    methods: {
        sendMessage() {
            this.sending = true;

            axios.post('/api/leads', {
                name: this.userName,
                email: this.userEmail,
                message: this.userMessage
            })
            .then((response) => {
                if(response.data.success) {
                    this.success = true;
                    this.userName = '';
                    this.userEmail = '';
                    this.userMessage = '';
                    this.errors = {};
                } else {
                    this.errors = response.data.errors;
                }

                this.sending = false;
            })
        }
    }
}
</script>