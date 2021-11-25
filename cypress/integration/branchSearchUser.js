describe("branch Search User", () => {
    it("Search User", () => {
        cy.visit("/login");
        cy.get("#login").type("Ali123").should("have.value", "Ali123");
        cy.get("#password").type("123456789").should("have.value", "123456789");
        cy.get("#login-btn").click();
        cy.visit("/branch/orders");
        cy.get(".search-bar").type("Omar");
        cy.get(".input-group-addon > button > .fa").click();
        cy.get(".containerV > .headerVehiclesSchedules > .btn").click();
        cy.get(
            "#addUserForm > :nth-child(2) > :nth-child(2) > :nth-child(1) > .input-group > .form-floating > .form-control"
        ).type("Omar User Al-Maktary");
        cy.get(
            "#addUserForm > :nth-child(2) > :nth-child(2) > :nth-child(2) > .input-group > .form-floating > .form-control"
        ).type("Omar630603User");
        cy.get(
            "#addUserForm > :nth-child(2) > :nth-child(3) > :nth-child(1) > .input-group > .form-floating > .form-control"
        ).type("omar.yem1111User@email.com");
        cy.get(
            "#addUserForm > :nth-child(2) > :nth-child(3) > :nth-child(1) > .input-group > .form-floating > .form-control"
        ).type("+62082123533955");
        cy.get(
            "#addUserForm > :nth-child(2) > :nth-child(3) > :nth-child(1) > .input-group > .form-floating > .form-control"
        ).type("Suhat");
        cy.get(
            "#addUserForm > :nth-child(2) > :nth-child(3) > :nth-child(1) > .input-group > .form-floating > .form-control"
        ).type("user123456");
        cy.get(
            "#addUserForm > :nth-child(2) > :nth-child(3) > :nth-child(1) > .input-group > .form-floating > .form-control"
        ).click();
        cy.visit("/branch/orders");
        cy.get(".search-bar").type("Omar630603User");
        cy.get(".input-group-addon > button > .fa").click();
    });
});
