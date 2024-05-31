import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css';

const EscrevaSuaMateria = () => {

    const modules = {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],       
            ['blockquote', 'code-block'],
            ['link', 'image', 'video'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
            [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
            [{ 'align': [] }],
            [{ 'direction': 'rtl' }],                         // text direction
          
            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
          
            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                    
        ]
    };

    return (
        <div className="mb-6">
            <label htmlFor="materia" className="font-averta font-extrabold text-laranja text-lg uppercase italic block">Escreva sua matéria</label>
            <ReactQuill modules={modules} className='h-96 bg-aurora overflow-hidden rounded-md font-averta mb-6' />
        </div>
    );
}

export default EscrevaSuaMateria;