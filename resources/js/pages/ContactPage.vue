<template>
    <div class="container">
        <h1>Contact</h1>

        <form action="">
            <div class="mb-3">
                <label for="user-name" class="form-label">Name</label>
                <input type="text" class="form-control" id="user-name">
            </div>
            <div class="mb-3">
                <label for="user-mail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="user-mail">
            </div>
            <div class="mb-3">
                <label for="user-content" class="form-label">Content</label>
                <textarea class="form-control" id="user-content" rows="8"></textarea>
            </div>
            
            <input type="submit" value="Submit">
        </form>
    </div>
</template>

<script>
export default {
    name: 'ContactPage'
}
</script>