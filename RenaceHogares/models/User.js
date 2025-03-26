const mongoose = require('mongoose');

// Definir el esquema de un usuario
const userSchema = new mongoose.Schema({
    nombre: { type: String, required: true },
    cedula: { type: String, required: true },
    telefono: { type: String, required: true },
    email: { type: String, required: true, unique: true },
    direccion: { type: String, required: true },
    password: { type: String, required: true }
});

// Crear el modelo a partir del esquema
const User = mongoose.model('User', userSchema);

// Exportar el modelo para usarlo en otros archivos
module.exports = User;
