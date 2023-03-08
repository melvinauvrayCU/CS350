<script lang="ts">
export default {
    name: "FooterComponent"
};
</script>
<template>
    <footer>
        <h4>© RecipeBuddy - 2023</h4>
        <h4>Team LLMAO</h4>
        <h5>Ava Megyeri, Flower Letourneau, Maddie Lopol, Melvin Auvray, Riley Outlaw
        </h5>
        <div class="linkContainer"><a href="https://website.cs350.melvinauvray.com/" target="_blank">Team's website</a> •
            <RouterLink to="/credits">Credits</RouterLink>
        </div>
    </footer>
</template>

<style scoped>
footer {
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
    padding: 20px;
    background-color: var(--color-accent);
    color: white;
    margin-top: 100px;
    font-size: 1.2em;
    padding-bottom: 40px;
}

footer h4 {
    font-family: "title";
    padding: 10px;
    font-weight: bold;
}

footer h5 {
    font-weight: normal;
    font-family: "common";
}

footer .linkContainer {
    font-family: "common";
    margin-top: 20px;
}

.linkContainer a {
    font-size: 0.83em;
    color: var(--color-background);
    transition: color .4s ease;
}

.linkContainer a:hover {
    color: var(--color-accent-light)
}
</style>