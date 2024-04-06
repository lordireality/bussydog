const BussyDog = new class {
    constructor(){
        this.Security = new BussyDogSecurity();
        this.Rest = new BussyDogRest();
    }
}