const express = require('express');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');

const app = express();

// Conexión a MongoDB
mongoose.connect('mongodb://localhost:27017/renacehogares', {
    useNewUrlParser: true,
    useUnifiedTopology: true
}, () => {
    console.log('Conectado a MongoDB');
});

// Esquema para la colección "usuario"
const usuarioSchema = new mongoose.Schema({
    nombre: String,
    cedula: String,
    telefono: String,
    email: String,
    direccion: String,
    password: String
});

const Usuario = mongoose.model('Usuario', usuarioSchema);

// Middleware para parsear datos JSON
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Ruta para manejar la solicitud POST del formulario
app.post('/registro', (req, res) => {
    const { nombre, cedula, telefono, email, direccion, password } = req.body;

    const nuevoUsuario = new Usuario({
        nombre,
        cedula,
        telefono,
        email,
        direccion,
        password
    });

    nuevoUsuario.save()
        .then(() => {
            res.json({ mensaje: 'Usuario registrado' });
        })
        .catch((err) => {
            res.status(400).json({ error: 'Hubo un error al registrar el usuario' });
        });
});

// Servir archivos estáticos (como HTML, CSS y JS)
app.use(express.static('public'));

// Iniciar servidor
app.listen(3000, () => {
    console.log('Servidor corriendo en http://localhost:3000');
});
